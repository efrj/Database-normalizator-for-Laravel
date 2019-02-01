# Database normalizator for Laravel

It is not good to use ORM with databases that are not properly structured.
There are tables and attributes named with numbers and even special characters.
This normalizer generates a model for the database table based on normalization made by the developer. No changes are made to the standard database.

If the naming of the user table and its attributes in the database is named by numbers, it is possible to generate the model with the normalized data. 

### Example:

Table: 1598 

Fields: 001, 002, 003, 004 

With the model generated with the table name the normalized attributes looks like this: 

Table: users 

Fields: id, name, password, email

Não é bom usar ORM com bancos de dados que não corretamente estruturados. 

Há tabelas e atributos nomeados com números e até mesmo caracteres especiais. 

Este normalizador gera um model para a tabela do banco de dados baseado na normalização feita pelo desenvolvedor. Nenhuma alteração é feita no banco de dados normalizado. 

Se no banco de dados a nomenclatura da tabela de usuários e seus atributos for nomeado por números é possível gerar o model com os dados normalizados. 

### Exemplo: 

Tabela: 1598 

Campos: 001, 002, 003, 004 

Com o model gerado com o nome da tabela a atributos normalizados fica assim: 

Tabela: users 

Campos: id, name, password, email
