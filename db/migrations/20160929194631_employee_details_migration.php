<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class EmployeeDetailsMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('employee_details', array('id' => false, 'primary_key' => 'employee_id'));
        $table->addColumn('employee_id', 'integer', array('identity' => true))
              ->addColumn('first_name', 'string')
              ->addColumn('last_name', 'string')
              ->addColumn('email', 'string')
              ->addColumn('job_role_id', 'integer')
              ->addColumn('is_deleted', 'integer', array('limit' => MysqlAdapter::INT_TINY))
              ->addColumn('created', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
              ->addForeignKey('job_role_id','job_role', 'job_role_id', array('delete' => 'RESTRICT', 'update' => 'CASCADE'))
              ->create();
    }
}
