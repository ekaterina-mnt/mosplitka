<?php
    require "../../functions.php";

try {
    add_url();
    session_start();

    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'checkauth') {
            echo "success\n";
            echo session_name() . "\n";
            echo "sessid=" . session_id() . "\n";
            exit();
        }
        if ($_GET['mode'] == 'init') {
            echo "zip=no" . "\n";
            echo "file_limit=204800" . "\n";
            exit();
        }
        if ($_GET['mode'] == 'query') {
            $product = sql("SELECT * FROM products LIMIT 1");

            //Получаем xml, который будем передавать 1С
            $xmlString = '<?xml version="1.0" encoding="UTF-8" ?>
                            <КоммерческаяИнформация ПараметрПакета="2" ВерсияСхемы="2.04">
                            <Классификатор>
                            <Ид>mosplitka</Ид>
                            <Наименование>Мосплитка</Наименование>
                                    
                            <Свойства>
                              <Свойство>
                                <Ид>Производитель_03189d7ec3904dab9ec1d3e597609119</Ид>
                                <Наименование>Производитель</Наименование>
                                <ТипЗначений>Строка</ТипЗначений>
                              </Свойство>
                            </Свойства>
                                    
                            <Группы>
                              <Группа>
                                <Ид>group4</Ид>
                                <Наименование>Керамика</Наименование>
                              </Группа>
                            </Группы>
                                    
                            </Классификатор>
                                    
                            <Каталог>
                            <Ид>catalog1</Ид>
                            <ИдКлассификатора>mosplitka</ИдКлассификатора>
                            <Наименование>Мосплитка</Наименование>
                            <Товары>';

            //здесь будет цикл

            //для каждого товара свой try (хотя может убрать потом)
            try {
                $xmlString .= '<Товар>
                                <Артикул>00382</Артикул>
                                <Ид>good10</Ид>
                                <Производитель>хелл</Производитель>
                                <ЕдиницаИзмерения>метр</ЕдиницаИзмерения>
                                <Наименование>Плитка 7182</Наименование>
                                <БазоваяЕдиница Код="796" НаименованиеПолное="Штука" МеждународноеСокращение="PCE">шт</БазоваяЕдиница>
                                <Изготовитель>хелл</Изготовитель>
                                <ЦенаЗаЕдиницу>6</ЦенаЗаЕдиницу>
                                <Группы>
                                  <Ид>group4</Ид>
                                </Группы>
                                <ЗначенияСвойств>
                                  <ЗначениеСвойства>
                                    <Ид>Производитель_03189d7ec3904dab9ec1d3e597609119</Ид>
                                    <Значение>мой произв</Значение>
                                  </ЗначениеСвойства>
                                </ЗначенияСвойств>
                                <Ширина>400</Ширина>
                                <Длина>470</Длина>
                                <Высота>580</Высота>
                                    
                                <ЗначенияРеквизитов>
                                  <ЗначениеРеквизита>
                                    <Наименование>Производитель</Наименование>
                                    <Значение>хелл</Значение>
                                  </ЗначениеРеквизита>
                                  <ЗначениеРеквизита>
                                    <ИД>Толщина_8be33020ef1a4438b99d3f2496b6a9cc</ИД>
                                    <Наименование>Толщина</Наименование>
                                    <Значение>100</Значение>
                                  </ЗначениеРеквизита>
                                </ЗначенияРеквизитов>';
            } catch (Throwable $e) {
                writeLog($e);
            }
            //конец цикла

            $xmlString .= '</Товар>
                                            </Товары>
                                            </Каталог>
                                        </КоммерческаяИнформация>';

            header("Content-type: text/xml");
            echo $xmlString;
        }
    }
} catch (Throwable $e) {
    writeLog($e);
}