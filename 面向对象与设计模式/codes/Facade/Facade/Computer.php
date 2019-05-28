<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/5/28
 * Time: 5:35 PM
 */

include_once "SubFacade/Cpu.php";
include_once "SubFacade/Disk.php";
include_once "SubFacade/Memory.php";

class Computer
{

    private $cpu;
    private $memory;
    private $disk;

    public function __construct()
    {
        $this->cpu = new Cpu();
        $this->memory = new Memory();
        $this->disk = new Disk();
    }

    public function start()
    {

        $this->cpu->start();
        $this->memory->start();
        $this->disk->start();
        echo '-------------------', PHP_EOL;
    }

    public function shutDown()
    {
        $this->disk->shutDown();
        $this->memory->shutDown();
        $this->cpu->shutDown();
    }

}