<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ==============================================================
 *
 * Golang
 *
 * ==============================================================
 *
 * @copyright  2023 Vittorio Peccenati, Università degli studi di Milano
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 * file da installare in: \\application\libraries\go_task.php
 * per funzionare richiede più memoria (application\libraries\LanguageTask.php)
 */

require_once('application/libraries/LanguageTask.php');

class GO_Task extends Task {

    public function __construct($filename, $input, $params) {
        parent::__construct($filename, $input, $params);
    }

    public static function getVersionCommand() {
        return array('go version', '/([0-9.]+)/');
    }

    //TODO
    // Compile the current source file in the current directory, saving
    // the compiled output in a file $this->executableFileName.
    // Sets $this->cmpinfo accordingly.

    // "build cache is required, but could not be located:
    // GOCACHE is not defined and neither $XDG_CACHE_HOME nor $HOME are defined
    // env -i GOCACHE=// HOME=// 
    public function compile() {
        
        $params = array(
            'memorylimit'   => 400,     // MB
            'cputime'       => 50,       // secs
            'numprocs'      => 100,
        );

        $src = basename($this->sourceFileName);
        $this->executableFileName = $execFileName = "$src.exe";
        $cmd = "env -i GOCACHE=/go_temp  go build -o $execFileName";
        
        $this->run_in_sandbox("mv ".$src." ./sources.go");
        $this->run_in_sandbox("go mod init esercizio.com/es");
        list($output, $this->cmpinfo) = $this->run_in_sandbox($cmd);

        //$test = fopen('/go_temp/test.out', 'w'); fwrite($test, $cmd."\n\n".$this->cmpinfo."\n\n".$output); fclose($test);
        //sleep(200);

    }

    // A default name for GO programs
    public function defaultFileName($sourcecode) {
        return 'prog.go';
    }


    // The executable is the output from the compilation
    public function getExecutablePath() {
        return "./" . $this->executableFileName;
    }


    public function getTargetFile() {
        return '';
    }
};
