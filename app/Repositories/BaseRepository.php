<?php
namespace Repo;

trait BaseRepository
{
    /**
     * [$obj_name Object returned from class]
     * @var [string]
     */
    private $obj_name;

    /**
     * Create data for Models
     * @param  array|null $data [description]
     * @param  [int]     $id    [id for Model]
     * @return [array]          [Data for Model]
     */
    public function create(array $data=null) {
        if (is_null($data)!=true) {
            foreach ($this->attr_original as $key_attr => $value_attr) {
                foreach ($data as $key_data => $value_data) {
                    if ($key_attr == $key_data) {
                        $this->{$key_data} = $value_data;
                        $this->{$this->obj_name}->{$value_attr} = $value_data;
                    }
                }
            }
        } else {
            foreach ($this->attr_original as $key => $value_attr) {
                $this->{$this->obj_name}->{$value_attr} = $this->{$key};
            }
        }

        if ($this->{$this->obj_name}->save()) {
            $this->id = $this->{$this->obj_name}->id;
            return $this;
        }
    }

    /**
     * Update data for Models
     * @param  array|null $data [description]
     * @param  [int]     $id    [id for Model]
     * @return [array]          [Data for Model]
     */
    public function update($id, array $data=null) {
        if (is_null($data)!=true) {
            foreach ($this->attr_original as $key_attr => $value_attr) {
                foreach ($data as $key_data => $value_data) {
                    if ($key_attr == $key_data) {
                        $this->{$key_data} = $value_data;
                        $this->{$this->obj_name}->{$value_attr} = $value_data;
                    }
                }
            }
        } else {
            foreach ($this->attr_original as $key => $value_attr) {
                $this->{$this->obj_name}->{$value_attr} = $this->{$key};
            }
        }

        if ($this->{$this->obj_name}->save()) {
            $this->id = $this->{$this->obj_name}->id;
            return $this;
        }
    }
}