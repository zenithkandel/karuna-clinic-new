<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Data CRUD';
$flash = getFlashMessage();
$csrf = generateCSRFToken();

$tables = $db->getCrudTables();
$selectedTable = isset($_GET['table']) ? trim((string) $_GET['table']) : '';
if (!in_array($selectedTable, $tables, true)) {
    $selectedTable = $tables[0] ?? '';
}

$columnsMeta = [];
$primaryKey = null;
$rows = [];
$editRow = null;
$editing = false;

if ($selectedTable !== '') {
    $columnsMeta = $db->getTableColumns($selectedTable);
    $primaryKey = $db->getTablePrimaryKey($selectedTable);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
            setFlashMessage('error', 'Invalid security token.');
            redirect('crud.php?table=' . urlencode($selectedTable));
        }

        $action = $_POST['crud_action'] ?? '';

        if ($action === 'create') {
            $payload = collectPayload($columnsMeta);
            $ok = $db->insertTableRow($selectedTable, $payload, $columnsMeta);
            setFlashMessage($ok ? 'success' : 'error', $ok ? 'Row created successfully.' : 'Failed to create row.');
            redirect('crud.php?table=' . urlencode($selectedTable));
        }

        if ($action === 'update' && $primaryKey !== null) {
            $pkValue = $_POST['pk_value'] ?? null;
            $payload = collectPayload($columnsMeta);
            $ok = $db->updateTableRow($selectedTable, $primaryKey, $pkValue, $payload, $columnsMeta);
            setFlashMessage($ok ? 'success' : 'error', $ok ? 'Row updated successfully.' : 'Failed to update row.');
            redirect('crud.php?table=' . urlencode($selectedTable));
        }

        if ($action === 'delete' && $primaryKey !== null) {
            $pkValue = $_POST['pk_value'] ?? null;
            $ok = $db->deleteTableRow($selectedTable, $primaryKey, $pkValue);
            setFlashMessage($ok ? 'success' : 'error', $ok ? 'Row deleted successfully.' : 'Failed to delete row.');
            redirect('crud.php?table=' . urlencode($selectedTable));
        }
    }

    if ($primaryKey !== null && isset($_GET['edit'])) {
        $editing = true;
        $editRow = $db->getRowByPrimaryKey($selectedTable, $primaryKey, $_GET['edit']);
    }

    $rows = $db->getTableRows($selectedTable, 300);
}

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-table"></i> Data CRUD</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?>
    </div>
<?php endif; ?>

<section class="panel" style="margin-bottom: 16px;">
    <form method="get" style="display:flex; align-items:end; gap:12px; flex-wrap:wrap;">
        <div class="form-row" style="margin-bottom:0; min-width: 280px;">
            <label for="table">Select Table</label>
            <select id="table" name="table" onchange="this.form.submit()">
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo htmlspecialchars($table); ?>" <?php echo $table === $selectedTable ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($table); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-accent" type="submit"><i class="fas fa-filter"></i> Open Table</button>
    </form>
</section>

<?php if ($selectedTable !== ''): ?>
    <section class="panel" style="margin-bottom: 16px;">
        <h2>
            <i class="fas fa-pen-to-square"></i>
            <?php echo $editing ? 'Edit Row in ' . htmlspecialchars($selectedTable) : 'Create Row in ' . htmlspecialchars($selectedTable); ?>
        </h2>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
            <input type="hidden" name="crud_action" value="<?php echo $editing ? 'update' : 'create'; ?>">
            <?php if ($editing && $primaryKey !== null): ?>
                <input type="hidden" name="pk_value"
                    value="<?php echo htmlspecialchars((string) ($editRow[$primaryKey] ?? '')); ?>">
            <?php endif; ?>

            <div class="grid-cards" style="grid-template-columns: repeat(auto-fit, minmax(260px,1fr));">
                <?php foreach ($columnsMeta as $column):
                    $field = $column['Field'];
                    $extra = strtolower((string) ($column['Extra'] ?? ''));
                    $isAuto = strpos($extra, 'auto_increment') !== false;
                    if ($isAuto && !$editing) {
                        continue;
                    }

                    $type = strtolower((string) ($column['Type'] ?? ''));
                    $value = $editing && is_array($editRow) ? (string) ($editRow[$field] ?? '') : '';
                    $required = ($column['Null'] ?? 'YES') === 'NO' && $column['Default'] === null && !$isAuto;
                    $readonly = $editing && $primaryKey === $field;
                    ?>
                    <div class="form-row" style="margin-bottom: 0;">
                        <label
                            for="field_<?php echo htmlspecialchars($field); ?>"><?php echo htmlspecialchars($field); ?></label>
                        <?php if ($readonly): ?>
                            <input id="field_<?php echo htmlspecialchars($field); ?>" name="<?php echo htmlspecialchars($field); ?>"
                                value="<?php echo htmlspecialchars($value); ?>" readonly>
                        <?php elseif (strpos($type, 'text') !== false): ?>
                            <textarea id="field_<?php echo htmlspecialchars($field); ?>"
                                name="<?php echo htmlspecialchars($field); ?>" rows="4" <?php echo $required ? 'required' : ''; ?>><?php echo htmlspecialchars($value); ?></textarea>
                        <?php elseif (strpos($type, 'enum(') === 0): ?>
                            <?php $enumOptions = parseEnumOptions($type); ?>
                            <select id="field_<?php echo htmlspecialchars($field); ?>"
                                name="<?php echo htmlspecialchars($field); ?>" <?php echo $required ? 'required' : ''; ?>>
                                <?php if (!$required): ?>
                                    <option value="">(empty)</option><?php endif; ?>
                                <?php foreach ($enumOptions as $opt): ?>
                                    <option value="<?php echo htmlspecialchars($opt); ?>" <?php echo $value === $opt ? 'selected' : ''; ?>><?php echo htmlspecialchars($opt); ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php elseif (strpos($type, 'int') !== false): ?>
                            <input id="field_<?php echo htmlspecialchars($field); ?>" type="number"
                                name="<?php echo htmlspecialchars($field); ?>" value="<?php echo htmlspecialchars($value); ?>" <?php echo $required ? 'required' : ''; ?>>
                        <?php elseif (strpos($type, 'date') === 0 && strpos($type, 'datetime') === false): ?>
                            <input id="field_<?php echo htmlspecialchars($field); ?>" type="date"
                                name="<?php echo htmlspecialchars($field); ?>" value="<?php echo htmlspecialchars($value); ?>" <?php echo $required ? 'required' : ''; ?>>
                        <?php elseif (strpos($type, 'datetime') === 0 || strpos($type, 'timestamp') === 0): ?>
                            <input id="field_<?php echo htmlspecialchars($field); ?>" type="text"
                                name="<?php echo htmlspecialchars($field); ?>" value="<?php echo htmlspecialchars($value); ?>"
                                placeholder="YYYY-MM-DD HH:MM:SS" <?php echo $required ? 'required' : ''; ?>>
                        <?php elseif (strpos($type, 'time') === 0): ?>
                            <input id="field_<?php echo htmlspecialchars($field); ?>" type="time"
                                name="<?php echo htmlspecialchars($field); ?>" value="<?php echo htmlspecialchars($value); ?>" <?php echo $required ? 'required' : ''; ?>>
                        <?php elseif ($selectedTable === 'admin_users' && $field === 'password_hash'): ?>
                            <input id="field_<?php echo htmlspecialchars($field); ?>" type="password"
                                name="<?php echo htmlspecialchars($field); ?>"
                                placeholder="<?php echo $editing ? 'Leave empty to keep current password' : 'Enter password'; ?>"
                                <?php echo (!$editing && $required) ? 'required' : ''; ?>>
                        <?php else: ?>
                            <input id="field_<?php echo htmlspecialchars($field); ?>" type="text"
                                name="<?php echo htmlspecialchars($field); ?>" value="<?php echo htmlspecialchars($value); ?>" <?php echo $required ? 'required' : ''; ?>>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="btn-row" style="margin-top: 14px;">
                <button class="btn btn-accent" type="submit">
                    <i class="fas fa-floppy-disk"></i>
                    <?php echo $editing ? 'Update Row' : 'Create Row'; ?>
                </button>
                <?php if ($editing): ?>
                    <a class="btn btn-ghost" href="crud.php?table=<?php echo urlencode($selectedTable); ?>"><i
                            class="fas fa-rotate-left"></i> Cancel Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </section>

    <section class="panel">
        <h2><i class="fas fa-list"></i> Rows in <?php echo htmlspecialchars($selectedTable); ?></h2>
        <table class="data-table">
            <thead>
                <tr>
                    <?php foreach ($columnsMeta as $column): ?>
                        <th><?php echo htmlspecialchars($column['Field']); ?></th>
                    <?php endforeach; ?>
                    <?php if ($primaryKey !== null): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($columnsMeta as $column):
                            $field = $column['Field'];
                            $display = isset($row[$field]) ? (string) $row[$field] : '';
                            if (strlen($display) > 90) {
                                $display = substr($display, 0, 87) . '...';
                            }
                            ?>
                            <td><?php echo htmlspecialchars($display); ?></td>
                        <?php endforeach; ?>
                        <?php if ($primaryKey !== null): ?>
                            <td>
                                <div class="btn-row">
                                    <a class="btn btn-ghost"
                                        href="crud.php?table=<?php echo urlencode($selectedTable); ?>&edit=<?php echo urlencode((string) $row[$primaryKey]); ?>"><i
                                            class="fas fa-pen"></i> Edit</a>
                                    <form method="post" onsubmit="return confirm('Delete this row?');">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                        <input type="hidden" name="crud_action" value="delete">
                                        <input type="hidden" name="pk_value"
                                            value="<?php echo htmlspecialchars((string) $row[$primaryKey]); ?>">
                                        <button class="btn" style="border: 1px solid var(--line);" type="submit"><i
                                                class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($rows)): ?>
                    <tr>
                        <td colspan="<?php echo count($columnsMeta) + ($primaryKey !== null ? 1 : 0); ?>">No rows found in this
                            table.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
<?php endif; ?>

<?php include __DIR__ . '/_layout_bottom.php'; ?>

<?php
function collectPayload($columnsMeta)
{
    $payload = [];
    foreach ($columnsMeta as $column) {
        $field = $column['Field'];
        if (array_key_exists($field, $_POST)) {
            $payload[$field] = trim((string) $_POST[$field]);
        }
    }
    return $payload;
}

function parseEnumOptions($type)
{
    if (preg_match('/^enum\((.*)\)$/i', $type, $matches) !== 1) {
        return [];
    }

    $items = str_getcsv($matches[1], ',', "'");
    return array_map('trim', $items);
}
