<?php
namespace comments;
use Codeception\Util\Stub as Strub;

class MigrateToNsTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;
    /**
     * @var \MigrateToNestedSetsCommand
     */
    protected $command;

    protected function _before()
    {
        $this->codeGuy->createConsoleYiiApp();
        require_once MOCKED_DIR.'Migrator.php';
        $this->codeGuy->setDbConnectionOptionsFromYiiConfig(APPLICATION_DIR.'config/db-test.php');
        $this->codeGuy->setDbDumpOptions(array('dump'=>'tests/_data/convert_to_ns.sql','populate'=>true));

        $this->command = new \MigrateToNestedSetsCommand('migratetonestedsets', null);
        $this->command->init();
        //$this->fixture->migrator = $this->getFilledMigratorStrub();
    }

    protected function _after()
    {
        unset($this->command);
    }

    // tests
    public function testMigrateToNestedSetsCommand()
    {
        $this->command->actionIndex();
        $this->expectOutputRegex('/Prepare for migrating to/is');
        $this->expectOutputRegex('/Migrating to \'.+\' migration -> \[OK\]/is');
        $this->expectOutputRegex('/Selecting models which contains comments -> \[OK\]/is');
        $this->expectOutputRegex('/Converted succesfully./is');
    }
}