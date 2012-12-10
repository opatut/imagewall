<?php
    global $_modelBindings;
    $_modelBindings = Array(); // array: table => bindings

    abstract class Model {
        private $_bindings = null;
        protected static $table;

        public function __construct() {
            $this->_bindings = $this->_getBindings();
        }

        private function _getBindings() {
            $this->_createBindings();
            global $_modelBindings;
            return $_modelBindings[static::$table];
        }

        protected function _createBindings () {
            global $db, $_modelBindings;
            if (!isset($_modelBindings[static::$table])) {
                $b = Array();
                $sql = 'SHOW COLUMNS FROM ' . static::$table;
                $result = $db->query($sql);
                if(!$result) {
                    die("Failed to read bindings. Did you set the table variable (" . static::$table . ")?");
                }
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $b[] = $row['Field'];
                }

                $_modelBindings[static::$table] = $b;
            }
        }

        public static function get($id) {
            $r = new static();
            $r->id = $id;
            return $r->load() ? $r : null;
        }

        public static function all() {
            return static::query("WHERE 1");
        }

        public static function query($condition, $params = Array()) {
            if(!is_array($params)) {
                if($params === null) {
                    $params = Array();
                } else {
                    $params = Array($params);
                }
            }

            global $db;
            $sql = 'SELECT * FROM ' . static::$table . " " . $condition;

            $stmt = $db->prepare($sql);
            $result = $stmt->execute($params);

            $l = Array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $l[] = static::loadFromRow($row);
            }
            return $l;
        }

        public static function queryOne($condition, $params = Array()) {
            $l = static::query($condition, $params);
            if(count($l) == 0) return null;
            if(count($l) == 1) return $l[0];
            return $l;
        }

        private static function loadFromRow($row) {
            $m = new static();
            $m->loadFromRowData($row);
            return $m;
        }

        private function loadFromRowData($row) {
            foreach($row as $key => $value) {
                $this->$key = $value;
            }
        }

        public function load() {
            $one = static::queryOne("WHERE id = ?", $this->id);
            if($one) $this->loadFromRowData($one);
            return $one != null;
        }

        public function save() {
            if($this->id > 0) {
                return $this->update();
            } else {
                return $this->insert();
            }
        }

        protected function insert() {
            $fields = '';
            $params = '';
            $bindParams = array();
            for ($i = 0; $i < count($this->_bindings); $i++) {
                if ($this->_bindings[$i] != "id") {
                    $fields .= $this->_bindings[$i];
                    $params .= '?';
                    if ($i + 1 < count($this->_bindings)) {
                        $fields .= ', ';
                        $params .= ', ';
                    }
                    $v =& $this->{$this->_bindings[$i]};
                    if(is_bool($v)) $v = $v ? 1 : 0;
                    $bindParams[] =& $v;
                }
            }

            global $db;
            $sql = 'INSERT INTO ' . static::$table . ' (' . $fields . ') VALUES (' . $params . ')';
            $stmt = $db->prepare($sql);

            if ($stmt) {
                $success = $stmt->execute($bindParams);
                if(!$success) {
                    $info = $stmt->errorInfo();

                    print "SQL ERROR for " . $sql . "\n";
                    print "\t" . $info[2] ."\n";
                    // print_r($bindParams);
                    // var_dump($sql, $bindParams);
                }
                $this->id = $db->lastInsertId();
                return $success;
            }
            return false;
        }

        protected function update() {
            $fields = '';
            $bindParams = array();

            for ($i = 0; $i < count($this->_bindings); $i++) {
                if ($this->_bindings[$i] != "id") {
                    $fields .= $this->_bindings[$i] . " = ?";
                    if ($i + 1 < count($this->_bindings)) {
                        $fields .= ', ';
                    }
                    $v =& $this->{$this->_bindings[$i]};
                    if(is_bool($v)) $v = $v ? 1 : 0;
                    $bindParams[] =& $v;
                }
            }

            global $db;
            $sql = 'UPDATE ' . static::$table . ' SET ' . $fields . ' WHERE id = ?';
            $bindParams[] =& $this->id;

            $stmt = $db->prepare($sql);
            return $stmt && $stmt->execute($bindParams);
        }

        public function delete() {
            if($this->id) {
                global $db;
                $sql = 'DELETE FROM ' . static::$table . ' WHERE id = ? LIMIT 1';
                $stmt = $db->prepare($sql);
                return $stmt && $stmt->execute(Array($this->id));
            }
            return false;
        }
    }
?>
