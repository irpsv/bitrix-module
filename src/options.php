<?if(!$USER->IsAdmin()) return;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

Loader::includeModule($mid);

//
// config
//

$options = [
	[
		'tab' => "Название вкладки",
		'options' => [
			'name1' => 'Название1',
			[
                'name' => 'name2',
                'label' => 'Название2',
				'type' => 'checkbox',
			],
			[
                'name' => 'name3',
                'label' => 'Название3',
                'type' => 'select',
                'values' => [
                    'val1' => 'label1',
                    'val2' => 'label2',
                    'val3' => 'label3',
                    'val4' => 'label4',
                ],
                'multiple' => false,
			]
		],
	],
	[
        'tab' => 'Простая вкладка',
        'options' => [
            [
                'group' => 'Название группы',
            ],
            'name4' => 'Название4',
            'name5' => 'Название5',
            [
                'group' => 'Название группы 2',
            ],
            'name6' => 'Название6',
            'name7' => 'Название7',
        ],
    ],
];

//
// process
//

$optionNames = [];
foreach ($options as $optionTab) {
    foreach ($optionTab['options'] as $name => $value) {
        if (is_string($value)) {
            $optionNames[] = $name;
        }
        else if (is_array($value)) {
            $name = $value['name'] ?? null;
            if ($name) {
                $optionNames[] = $name;
            }
        }
    }
}

if ($_POST['save'] ?? $_POST['apply'] ?? false) {
	foreach ($optionNames as $name) {
		$value = $_POST[$name] ?? null;
		$ret = Option::set($mid, $name, $value);
	}
}


$aTabs = array_map(function($item) {
    static $i = 0;
    return [
        'ICON' => '',
        'DIV' => 'tab'.($i++),
        'TAB' => $item['tab'],
        'TITLE' => $item['tab'],
    ];
}, $options);

$tabControl = new CAdminTabControl('tabControl', $aTabs);
$actionUrl = $APPLICATION->GetCurPage() ."?mid=".urlencode($mid)."&lang=".LANGUAGE_ID;

?>
<form method="post" action="<?= $actionUrl ?>">
    <?
	echo bitrix_sessid_post();

	$tabControl->Begin();
	foreach ($options as $optionTab) {
        $tabControl->BeginNextTab();
        foreach ($optionTab['options'] as $name => $value) {
            if (is_string($value)) {
                $optionName = $name;
                $optionLabel = $value;
                $optionType = "text";
            }
            else if (is_array($value)) {
                $optionGroup = $value['group'] ?? null;
                if ($optionGroup) {
                    echo "<tr class='heading'><td colspan='2'>{$optionGroup}</td></tr>";
                    continue;
                }

                $optionName = $value['name'] ?? null;
                if (!$optionName) {
                    continue;
                }

                $optionLabel = $value['label'] ?? $optionName;
                $optionType = $value['type'] ?? 'text';
            }

            $optionValue = (string) Option::get($mid, $optionName);
            ?>
            <tr>
                <td class="adm-detail-content-cell-l">
                    <?= $optionLabel ?>
                </td>
                <td class="adm-detail-content-cell-r">
                    <?php
                    switch ($optionType) {
                        case 'select':
                            $values = $value['values'];
                            $multiple = ($value['multiple'] ?? false);
                            $size = $multiple ? 5 : 1;
                            echo "<select class='typeselect' name='{$optionName}' size='{$size}' ".($multiple ? 'multiple' : '').">";
                            foreach ($values as $key => $value) {
                                if (is_integer($key)) {
                                    $selected = "{$value}" === "{$optionValue}" ? "selected" : "";
                                    echo "<option {$selected}>{$value}</option>";
                                }
                                else {
                                    $selected = "{$key}" === "{$optionValue}" ? "selected" : "";
                                    echo "<option value='{$key}' {$selected}>{$value}</option>";
                                }
                            }
                            echo "</select>";
                            break;

                        case 'checkbox':
                            $optionValue = $optionValue ?: 'N';
                            $checked = $optionValue == 'Y' ? "checked" : "";
                            echo "
                            <input class='adm-designed-checkbox' type='checkbox' id='{$optionName}' name='{$optionName}' value='Y' {$checked}>
                            <label class='adm-designed-checkbox-label' for='{$optionName}'></label>
                            ";
                            break;

                        default:
                            echo "<input type='{$optionType}' name='{$optionName}' value='{$optionValue}'>";
                            break;
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
	}

	$tabControl->Buttons([]);
	$tabControl->End();

?>
</form>
