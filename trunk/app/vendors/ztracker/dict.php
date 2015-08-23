<?php

require_once("benc.php");
$max_torrent_size = 1000000;

ini_set("upload_max_filesize",$max_torrent_size);

class TDict {
	var $_dict;
	var $ErrorMsg;
	var $debug;

	function TDict($fname = '', $fsize = 0) {
		if($fname == '' && $fsize == 0) {
			$this->_dict = null;
			return;
		}

		if($fname == '' && $fsize != 0) {
			$this->setDict($fsize);
			return;
		}

		$this->_dict = bdec_file($fname, $fsize);
		if(!$this->_dict) {
			$this->ErrorMsg = 'Error decoding file';
		} else {
			$this->ErrorMsg = '';
		}
	}

	function setDict($dict) {
		$this->_dict = $dict;
	}

	function check($value) {
		$dd = $this->_dict["value"];
		$a = explode(":", $value);
		$ret = array();
		foreach ($a as $k) {
			unset($t);
			if (preg_match('/^(.*)\((.*)\)$/', $k, $m)) {
				$k = $m[1];
				$t = $m[2];
			}
		
			if (!isset($dd[$k])) {
				$this->ErrorMsg = "dictionary is missing key(s)";
				return false;
			}
		
			if (isset($t)) {
				if ($dd[$k]["type"] != $t) {
					$this->ErrorMsg = "invalid entry in dictionary";
					return false;
				}
				$ret[] = $dd[$k]["value"];
			} else
				if($dd[$k]["type"] == 'dictionary' || $dd[$k]["type"] == 'list')
					$ret = $dd[$k];
				else
					$ret[] = $dd[$k];
		}
		return $ret;
	}
	
	function get($key, $type) {
		$dd = $this->_dict["value"];
		if (!isset($dd[$key]))
			return;
		$value = $dd[$key];
		if ($value["type"] != $type) {
			$this->ErrorMsg = "invalid dictionary entry type";
			return;
		}
		return $value["value"];
	}

	function _dump() {
		function display_dict($dict, $level = 0) {
			$s = '';
			for($i=0;$i<$level;$i++) $s .= '&nbsp;&nbsp;&nbsp;';
			foreach($dict as $k => $v) {
				if(is_array($v)) {
					echo $s."Dump $k array:<br/>";
					display_dict($v, $level + 1);
				} else 
					echo $s."\$dict[$k] => $v<br/>";
			}
		}
		display_dict($this->_dict);
	}

    function hashGetter($hashStr) {
        $m = eval("if(isset(\$this->_dict$hashStr)) return \$this->_dict$hashStr; else return \"unknown hash\";");
        return $m;
    }

    function hashSetter($hashStr, $value) {
        if(!isset($hashStr) || !isset($value)) return;
        eval("\$this->_dict$hashStr = \$value;");
    }

    function unsetHash($hashStr) {
        if(!isset($hashStr)) return;
        eval("unset(\$this->_dict$hashStr);");
    }

    function doubleUp() {
        $this->_dict=bdec(benc($this->_dict));
    }
}

class TFileList {
	var $totalSize;
	var $count;
	var $filelist;

	function TFileList($list) {
		if(isset($list) && count($list)) {

			foreach($list as $v) {
                $tlist[] = new TDict('', $v);
            }

			$this->count = count($tlist);
			$this->totalSize = 0;
			$this->filelist = array();

			foreach($tlist as $v) {
				list($fl, $fp)= $v->check('length(integer):path(list)');
				$this->totalSize += $fl;
				$ffa = array();
				foreach ($fp as $fpe) {
					if ($fpe["type"] != "string")
						die ("filename error");
					$ffa[] = $fpe["value"];
				}
				if(!count($ffa))
					die("filename error");
				$fpe = implode("/", $ffa);
				$this->filelist[] = array('filename' => $fpe, 'size' => $fl);

				if ($fpe == 'Thumbs.db')
				{
					stderr("¿¿¿¿¿¿", "¿ ¿¿¿¿¿¿¿ ¿¿ ¿¿¿¿¿ ¿¿¿¿ ¿¿¿¿¿¿ Thumbs.db!");
					die;
				}
			}
		}
	}

	function _dump() {
		foreach($this->filelist as $v) {
			var_dump($v);
		}
	}
}

?>
