<?php
/**
 * Database Helper Class
 * Centralized DB operations for public site and admin portal.
 */

require_once __DIR__ . '/../config/database.php';

class DatabaseHelper
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $this->pdo = getDBConnection();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function getActiveServices()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM active_services");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error fetching services: ' . $e->getMessage());
            return [];
        }
    }

    public function getActiveDoctors()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM active_doctors");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error fetching doctors: ' . $e->getMessage());
            return [];
        }
    }

    public function getDoctorById($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM doctors WHERE id = ? AND is_active = 1');
            $stmt->execute([(int) $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Error fetching doctor: ' . $e->getMessage());
            return null;
        }
    }

    public function saveAppointment($data)
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO appointments (doctor_id, patient_name, patient_email, patient_phone, appointment_date, appointment_time, service_type, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
            );

            return $stmt->execute([
                $data['doctor_id'] ?? null,
                $data['patient_name'],
                $data['patient_email'] ?? null,
                $data['patient_phone'],
                $data['appointment_date'],
                $data['appointment_time'],
                $data['service_type'] ?? null,
                $data['message'] ?? null
            ]);
        } catch (PDOException $e) {
            error_log('Error saving appointment: ' . $e->getMessage());
            return false;
        }
    }

    public function saveContactMessage($data)
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)'
            );

            return $stmt->execute([
                $data['name'],
                $data['email'],
                $data['phone'] ?? null,
                $data['subject'] ?? null,
                $data['message']
            ]);
        } catch (PDOException $e) {
            error_log('Error saving contact message: ' . $e->getMessage());
            return false;
        }
    }

    public function getApprovedTestimonials($limit = 10)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM testimonials WHERE is_approved = 1 AND is_active = 1 ORDER BY created_at DESC LIMIT ?');
            $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error fetching testimonials: ' . $e->getMessage());
            return [];
        }
    }

    public function getSetting($key, $default = null)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT setting_value FROM site_settings WHERE setting_key = ?');
            $stmt->execute([$key]);
            $result = $stmt->fetch();
            return $result ? $result['setting_value'] : $default;
        } catch (PDOException $e) {
            error_log('Error fetching setting: ' . $e->getMessage());
            return $default;
        }
    }

    public function getSettingsMap()
    {
        try {
            $rows = $this->pdo->query('SELECT setting_key, setting_value FROM site_settings')->fetchAll();
            $settings = [];
            foreach ($rows as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
            return $settings;
        } catch (PDOException $e) {
            error_log('Error fetching settings map: ' . $e->getMessage());
            return [];
        }
    }

    public function updateSetting($key, $value)
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
            return $stmt->execute([$key, $value]);
        } catch (PDOException $e) {
            error_log('Error updating setting: ' . $e->getMessage());
            return false;
        }
    }

    public function getRecentAppointments($limit = 10)
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT a.*, d.name as doctor_name FROM appointments a LEFT JOIN doctors d ON a.doctor_id = d.id ORDER BY a.created_at DESC LIMIT ?'
            );
            $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error fetching appointments: ' . $e->getMessage());
            return [];
        }
    }

    public function getContactMessages($limit = 200)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT ?');
            $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error fetching contact messages: ' . $e->getMessage());
            return [];
        }
    }

    public function markMessageRead($messageId)
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = ?');
            return $stmt->execute([(int) $messageId]);
        } catch (PDOException $e) {
            error_log('Error marking message read: ' . $e->getMessage());
            return false;
        }
    }

    public function getNotices($activeOnly = true, $limit = 50)
    {
        try {
            $sql = 'SELECT * FROM notices';
            if ($activeOnly) {
                $sql .= ' WHERE is_active = 1';
            }
            $sql .= ' ORDER BY created_at DESC LIMIT ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error fetching notices: ' . $e->getMessage());
            return [];
        }
    }

    public function createNotice($data)
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO notices (title, description, target_url, image, is_active, created_by) VALUES (?, ?, ?, ?, ?, ?)');
            return $stmt->execute([
                $data['title'],
                $data['description'],
                $data['target_url'] ?? null,
                $data['image'] ?? null,
                isset($data['is_active']) ? (int) $data['is_active'] : 1,
                $data['created_by'] ?? null
            ]);
        } catch (PDOException $e) {
            error_log('Error creating notice: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteNotice($noticeId)
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM notices WHERE id = ?');
            return $stmt->execute([(int) $noticeId]);
        } catch (PDOException $e) {
            error_log('Error deleting notice: ' . $e->getMessage());
            return false;
        }
    }

    private function sanitizeIdentifier($identifier)
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $identifier)) {
            throw new InvalidArgumentException('Invalid identifier.');
        }
        return $identifier;
    }

    public function getCrudTables()
    {
        try {
            $databaseName = DB_NAME;
            $stmt = $this->pdo->prepare(
                'SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_TYPE = "BASE TABLE" ORDER BY TABLE_NAME ASC'
            );
            $stmt->execute([$databaseName]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log('Error fetching CRUD tables: ' . $e->getMessage());
            return [];
        }
    }

    public function getTableColumns($table)
    {
        try {
            $table = $this->sanitizeIdentifier($table);
            $stmt = $this->pdo->query('DESCRIBE `' . $table . '`');
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log('Error fetching table columns: ' . $e->getMessage());
            return [];
        }
    }

    public function getTablePrimaryKey($table)
    {
        $columns = $this->getTableColumns($table);
        foreach ($columns as $column) {
            if (($column['Key'] ?? '') === 'PRI') {
                return $column['Field'];
            }
        }
        return null;
    }

    public function getTableRows($table, $limit = 200)
    {
        try {
            $table = $this->sanitizeIdentifier($table);
            $pk = $this->getTablePrimaryKey($table);
            $order = $pk ? ' ORDER BY `' . $pk . '` DESC' : '';
            $stmt = $this->pdo->prepare('SELECT * FROM `' . $table . '`' . $order . ' LIMIT ?');
            $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log('Error fetching table rows: ' . $e->getMessage());
            return [];
        }
    }

    public function getRowByPrimaryKey($table, $pkField, $pkValue)
    {
        try {
            $table = $this->sanitizeIdentifier($table);
            $pkField = $this->sanitizeIdentifier($pkField);
            $stmt = $this->pdo->prepare('SELECT * FROM `' . $table . '` WHERE `' . $pkField . '` = ? LIMIT 1');
            $stmt->execute([$pkValue]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log('Error fetching row by primary key: ' . $e->getMessage());
            return null;
        }
    }

    public function insertTableRow($table, $data, $columnsMeta)
    {
        try {
            $table = $this->sanitizeIdentifier($table);
            $fields = [];
            $placeholders = [];
            $values = [];

            foreach ($columnsMeta as $columnMeta) {
                $field = $columnMeta['Field'];
                $extra = strtolower((string) ($columnMeta['Extra'] ?? ''));
                if (strpos($extra, 'auto_increment') !== false) {
                    continue;
                }

                if (!array_key_exists($field, $data)) {
                    continue;
                }

                $value = $data[$field];
                if ($table === 'admin_users' && $field === 'password_hash') {
                    if ($value === '' || $value === null) {
                        continue;
                    }
                    $value = password_hash($value, PASSWORD_DEFAULT);
                }

                $fields[] = '`' . $field . '`';
                $placeholders[] = '?';
                $values[] = ($value === '') ? null : $value;
            }

            if (empty($fields)) {
                return false;
            }

            $sql = 'INSERT INTO `' . $table . '` (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $placeholders) . ')';
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (Exception $e) {
            error_log('Error inserting table row: ' . $e->getMessage());
            return false;
        }
    }

    public function updateTableRow($table, $pkField, $pkValue, $data, $columnsMeta)
    {
        try {
            $table = $this->sanitizeIdentifier($table);
            $pkField = $this->sanitizeIdentifier($pkField);
            $updates = [];
            $values = [];

            foreach ($columnsMeta as $columnMeta) {
                $field = $columnMeta['Field'];
                if ($field === $pkField || !array_key_exists($field, $data)) {
                    continue;
                }

                $value = $data[$field];
                if ($table === 'admin_users' && $field === 'password_hash') {
                    if ($value === '' || $value === null) {
                        continue;
                    }
                    $value = password_hash($value, PASSWORD_DEFAULT);
                }

                $updates[] = '`' . $field . '` = ?';
                $values[] = ($value === '') ? null : $value;
            }

            if (empty($updates)) {
                return false;
            }

            $values[] = $pkValue;
            $sql = 'UPDATE `' . $table . '` SET ' . implode(', ', $updates) . ' WHERE `' . $pkField . '` = ?';
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (Exception $e) {
            error_log('Error updating table row: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteTableRow($table, $pkField, $pkValue)
    {
        try {
            $table = $this->sanitizeIdentifier($table);
            $pkField = $this->sanitizeIdentifier($pkField);
            $stmt = $this->pdo->prepare('DELETE FROM `' . $table . '` WHERE `' . $pkField . '` = ?');
            return $stmt->execute([$pkValue]);
        } catch (Exception $e) {
            error_log('Error deleting table row: ' . $e->getMessage());
            return false;
        }
    }

    public function authenticateAdmin($username, $password)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM admin_users WHERE username = ? AND is_active = 1 LIMIT 1');
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if (!$admin || !password_verify($password, $admin['password_hash'])) {
                return null;
            }

            $updateStmt = $this->pdo->prepare('UPDATE admin_users SET last_login = NOW() WHERE id = ?');
            $updateStmt->execute([$admin['id']]);

            return $admin;
        } catch (PDOException $e) {
            error_log('Error authenticating admin: ' . $e->getMessage());
            return null;
        }
    }

    public function isDatabaseSetup()
    {
        try {
            $tables = ['services', 'doctors', 'appointments', 'contact_messages', 'admin_users', 'site_settings', 'notices'];
            foreach ($tables as $table) {
                $stmt = $this->pdo->query("SHOW TABLES LIKE '$table'");
                if ($stmt->rowCount() === 0) {
                    return false;
                }
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getStats()
    {
        try {
            $stats = [];
            $stats['services'] = (int) $this->pdo->query('SELECT COUNT(*) as count FROM services WHERE is_active = 1')->fetch()['count'];
            $stats['doctors'] = (int) $this->pdo->query('SELECT COUNT(*) as count FROM doctors WHERE is_active = 1')->fetch()['count'];
            $stats['appointments'] = (int) $this->pdo->query('SELECT COUNT(*) as count FROM appointments')->fetch()['count'];
            $stats['messages'] = (int) $this->pdo->query('SELECT COUNT(*) as count FROM contact_messages')->fetch()['count'];
            $stats['unread_messages'] = (int) $this->pdo->query('SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0')->fetch()['count'];
            $stats['notices'] = (int) $this->pdo->query('SELECT COUNT(*) as count FROM notices WHERE is_active = 1')->fetch()['count'];
            return $stats;
        } catch (PDOException $e) {
            error_log('Error fetching stats: ' . $e->getMessage());
            return [
                'services' => 0,
                'doctors' => 0,
                'appointments' => 0,
                'messages' => 0,
                'unread_messages' => 0,
                'notices' => 0
            ];
        }
    }
}
?>