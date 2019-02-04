<?php
namespace Repo;

use App\Models\Table;
use App\Models\Field;

class TableRepository
{
    // use BaseRepository;

    private $table;
    private $field;

    /**
     * [__construct Inicialize a new Table Object]
     * @param Table $table Object for Table Class
     */
    public function __construct( Table $table, Field $field ) {
        $this->table = $table;
        $this->field = $field;
    }

    public function find_id( $id ) {
        return $this->table->find($id);
    }

    public function find_by_name( $name ) {
        $table = $this->table->where('name', "$name" )->first();
        return $table;
    }

    public function find_all() {
        return $this->table->all();
    }

    public function find_normalized() {
        $tables = \DB::select("select id as tb_id, name, class_name, ( select count(standard_attribute) from fields where table_id = tb_id ) as total_normalized, ( select count(*) from fields where table_id = tb_id ) as total_fields from tables where class_name <> '' ORDER BY name ASC");
        return $tables;
    }

    public function find_not_normalized() {
        $tables = \DB::select("select * from tables where class_name IS NULL OR class_name = '' ORDER BY name ASC");
        return $tables;
    }

    public function update_tables( $tables ) {
        foreach ($tables as $key => $t) {
            if ( ! empty( $t ) ) {
                $table = $this->table->where('name', "$key" )
                        ->first();
                $table->class_name = $t;
                $table->save();
            }
        }
        return true;
    }

    public function normalize_table( $table, $fields ) {
        $table = $this->find_by_name( $table );
        $table = $this->find_id( $table->id );

        foreach ($fields as $key => $field_normalize) {
            $field = $this->field->where('table_id', "$table->id" )
                ->where('field_name', "$key" )
                ->first();
            $field->standard_attribute = $field_normalize['standard_attribute'];
            $field->save();
        }
        return true;
    }

    public function show_cols( $table ) {
        $table = $this->table->where('name', "$table")
            ->first();
    }

    public function integration() {
        $db = \DB::select("select database() as name");
        $db = $db[0]->name;
        $tables = \DB::select("SELECT table_name FROM information_schema.tables where table_schema='{$db}' and table_name not in ('users', 'migrations', 'fields', 'password_resets', 'tables')");

        foreach ($tables as $key => $table) {
            $table_integration = new Table;
            $table_integration->name = $table->table_name;
            $table_integration->save();

            $fields = \DB::select("SHOW COLUMNS FROM {$table_integration->name}");

            foreach ($fields as $key => $field) {
                $field_integration = new Field;

                $field_integration->field_name    = $field->Field;
                $field_integration->field_type    = $field->Type;
                $field_integration->field_null    = $field->Null;
                $field_integration->field_key     = $field->Key;
                $field_integration->field_default = $field->Default;
                $field_integration->field_extra   = $field->Extra;
                $field_integration->table_id      = $table_integration->id;

                if ( is_pk( $field->Key, $field->Extra ) ) {
                    $field_integration->standard_attribute = 'id';
                }

                if ( is_fk($field->Field) ) {
                    $field_integration->table_related_name = get_table_by_fk( $field->Field );
                    $field_integration->field_related_name = get_field_by_fk( $field->Field );
                    $field_integration->type_related       = 'belongsTo';
                }

                $field_integration->save();
            }
        }
    }

    public function remove_normalization( $table ) {
        $table_remove = $this->find_by_name( $table );
        $table_remove->class_name = null;
        $table_remove->save();

        unlink( "../storage/app/normalize/Models/".$table_remove->class_name.'.php' );
        unlink( "../storage/app/normalize/Repositories/".$table_remove->class_name.'Repository.php' );
        return true;
    }

    public function model_generate( $table ) {
        $table = $this->find_by_name( $table );
        $primary_key = $this->field->where('table_id', "{$table->id}")
            ->where('field_key', 'PRI')
            ->first();

        $data_file_model = '<?php' . "\n";
        $data_file_model .= 'namespace App\Models;' . "\n" . "\n";
        $data_file_model .= 'use Illuminate\Database\Eloquent\Model;' . "\n" . "\n";
        $data_file_model .= 'class ';
        $data_file_model .= ucfirst($table->class_name);
        $data_file_model .= ' extends Model' . "\n";
        $data_file_model .= '{' . "\n" . "\n";

        $data_file_model .= "\t" . '/**' . "\n";
        $data_file_model .= "\t" . ' * Table Name' . "\n";
        $data_file_model .= "\t" . ' *' . "\n";
        $data_file_model .= "\t" . ' * @var string' . "\n";
        $data_file_model .= "\t" . ' */' . "\n";
        $data_file_model .= "\t" . 'protected $table = ' . "'". $table->name . "';" . "\n" . "\n";

        $data_file_model .= "\t" . '/**' . "\n";
        $data_file_model .= "\t" . '* Table Primary Key' . "\n";
        $data_file_model .= "\t" . '* @var string' . "\n";
        $data_file_model .= "\t" . '*/' . "\n";
        $data_file_model .= "\t" . 'protected $primaryKey = ';
        $data_file_model .= "'" . $primary_key->field_name . "';" . "\n" . "\n";
        
        $data_file_model .= "\t" . '/**' . "\n";
        $data_file_model .= "\t" . ' * Indicates if the model should be timestamped.' . "\n";
        $data_file_model .= "\t" . ' *' . "\n";
        $data_file_model .= "\t" . ' * @var bool' . "\n";
        $data_file_model .= "\t" . ' */' . "\n";
        $data_file_model .= "\t" . 'public $timestamps = false;' . "\n" . "\n";

        $data_file_model .= "\t" . '/**' . "\n";
        $data_file_model .= "\t" . ' * Attributes list map' . "\n";
        $data_file_model .= "\t" . ' * @var array $maps' . "\n";
        $data_file_model .= "\t" . ' */' . "\n";
        $data_file_model .= "\t" . 'protected $maps = [' . "\n";
        foreach ( $table->fields as $key => $attr ) {
            if ( ! empty( $attr->standard_attribute) ) {
                $data_file_model .= "\t" . "\t" . "'" . $attr->field_name . "'" . ' => ' . "'" . $attr->standard_attribute . "'," . "\n";
            }
        }
        $data_file_model .= "\t" . '];' . "\n" . "\n";

        $data_file_model .= "\t" . '/**' . "\n";
        $data_file_model .= "\t" . ' * Attributes list hidden' . "\n";
        $data_file_model .= "\t" . ' * @var array $hidden' . "\n";
        $data_file_model .= "\t" . ' */' . "\n";
        $data_file_model .= "\t" . 'protected $hidden = [' . "\n";
        foreach ( $table->fields as $key => $attr ) {
            $data_file_model .= "\t" . "\t" . "'" . $attr->field_name . "'," . "\n";
        }
        $data_file_model .= "\t" . '];' . "\n" . "\n";

        $data_file_model .= "\t" . '/**' . "\n";
        $data_file_model .= "\t" . ' * Attributes list append' . "\n";
        $data_file_model .= "\t" . ' * @var array $appends' . "\n";
        $data_file_model .= "\t" . ' */' . "\n";
        $data_file_model .= "\t" . 'protected $appends = [' . "\n";
        foreach ( $table->fields as $key => $attr ) {
            if ( ! empty( $attr->standard_attribute) ) {
                $data_file_model .= "\t" . "\t" . "'" . $attr->standard_attribute . "'," . "\n";
            }
        }
        $data_file_model .= "\t" . '];' . "\n" . "\n";

        foreach ( $table->fields as $key => $attr ) {
            if ( ! empty( $attr->standard_attribute) ) {
                $data_file_model .= "\t" . '/**' . "\n";
                $data_file_model .= "\t" . ' * Get ' . ucfirst($attr->standard_attribute) . ' attribute' . "\n";
                $data_file_model .= "\t" . ' * @return string ' . ucfirst($attr->standard_attribute) . ' ' . $table->class_name . "\n";
                $data_file_model .= "\t" . ' */' . "\n";
                $data_file_model .= "\t" . 'public function get' . normalize_attribute_name($attr->standard_attribute) . 'Attribute() {' . "\n";
                $data_file_model .= "\t" . "\t" . 'return ' . '$this->' . $attr->field_name . ';' . "\n";
                $data_file_model .= "\t" . '}' . "\n" . "\n";
            }
        }

        foreach ($table->fields as $key => $field) {
            if ( is_fk( $field->field_name ) ) {
                $table_name = get_table_by_fk($field->field_name);
                $table_belongs = $this->find_by_name( "$table_name" );
                if ( ! empty($table_belongs->class_name) ) {
                    $data_file_model .= "\t" . 'public function ' . lcfirst($table_belongs->class_name) . '() {' . "\n";
                    $data_file_model .= "\t" . "\t" . 'return ' . '$this->belongsTo(\'App\Models\\' . $table_belongs->class_name . "', '" . $field->field_name . "','" . $field->field_related_name . "');" . "\n";
                    $data_file_model .= "\t" . '}' . "\n" . "\n";
                }
            }
        }

        $fields = $this->field->where('table_related_name', $table->name)
            ->get();
        foreach ($fields as $key => $field) {
            if ( is_fk( $field->field_name ) ) {
                if ( ! empty($field->table->class_name) ) {
                    $data_file_model .= "\t" . 'public function ' . lcfirst($field->table->class_name) . 's() {' . "\n";
                    $data_file_model .= "\t" . "\t" . 'return ' . '$this->hasMany(\'App\Models\\' . $field->table->class_name . "', '" . $field->field_name . "');" . "\n";
                    $data_file_model .= "\t" . '}' . "\n" . "\n";
                }
            }
        }

        $data_file_model .= '}';

        file_put_contents( "../storage/app/normalize/Models/" . ucfirst($table->class_name) . '.php', $data_file_model );
    }

    public function get_belongs_to( $table ) {
        $table = $this->find_by_name( $table );

        foreach ($table->fields as $key => $field) {
            if ( is_fk( $field->field_name ) ) {
                $table_belongs = $this->find_by_name( get_table_by_fk($field->field_name) );
                if ( ! empty($table_belongs->class_name) ) {
                    echo '<strong>Tabela:</strong> ' . get_table_by_fk($field->field_name) . ' <br> ';
                    echo '<strong>FK:</strong> ' . $field->field_name;
                    echo '<br>';
                    echo '<hr>';
                }
            }
        }
    }

    public function get_has_many( $table ) {
        $table = $this->find_by_name( $table );
        $fields = $this->field->where('table_related_name', $table->name)
            ->get();

        foreach ($fields as $key => $field) {
            if ( is_fk( $field->field_name ) ) {
                if ( ! empty($field->table->class_name) ) {
                    echo '<strong>Tabela:</strong> ' . get_table_by_fk($field->field_name) . ' <br> ';
                    echo '<strong>FK:</strong> ' . $field->field_name;
                    echo '<br>';
                    echo '<hr>';
                }
            }
        }
    }
}