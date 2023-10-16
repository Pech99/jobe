<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ==============================================================
 *
 * C
 *
 * ==============================================================
 *
 * @copyright  2023 Vittorio Peccenati, Università degli studi di Milano
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('application/libraries/LanguageTask.php');

class GO_Task extends Task {

    public function __construct($filename, $input, $params) {
        parent::__construct($filename, $input, $params);
        //$this->default_params['compileargs'] = array('-Wall');
    }

    public static function getVersionCommand() {
        //return array('go version', '/go \(.*\) ([0-9.]*)/');
        return array('go version', '');

    }

    //TODO
    public function compile() {
        $src = basename($this->sourceFileName);
        $this->executableFileName = $execFileName = "$src.exe";
        $compileargs = $this->getParam('compileargs');
        $linkargs = $this->getParam('linkargs');
        $cmd = "go build" . implode(' ', $compileargs) . " -o $execFileName $src " . implode(' ', $linkargs);
        list($output, $this->cmpinfo) = $this->run_in_sandbox($cmd);
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
