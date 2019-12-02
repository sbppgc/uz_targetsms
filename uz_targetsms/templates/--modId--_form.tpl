##--system info: module_owner="##section##" module="##modId##" system="1"--##
%%include_template "templates/modules/_form.tpl"%%


<!--#set var="input_field(name=notes)" value="
<tr>
    <td colspan="2">
        <div>
            <div>
                <a href="https://sms.targetsms.ru/?ref=amirocms" target="_blank"><img src="##root_path_www##_local/modules/distrib/configs/ami_clean/uz_targetsms/img/adm_logo.png" alt="TargetSMS" /></a>
            </div>
            <div class="uz_tagetsms_buttons_box">
                <a class="uz_targetsms_inline_btn" href="https://sms.targetsms.ru/ru/reg.html?ref=amirocms" target="_blank">Регистрация</a>
                <a class="uz_targetsms_inline_btn" href="/_admin/srv_options.php?flt_module=##modId##&flt_owner=##section##&flt_mode=" target="_blank">Настройка модуля</a>
                <a class="uz_targetsms_inline_btn" href="/_admin/engine.php?mod_id=modules_templates#mid=modules_templates&header=inst_uz_targetsms_sms_templates" target="_blank">Настройка шаблонов</a>
                <a class="uz_targetsms_inline_btn" href="https://sms.targetsms.ru/ru/cabinet/pay.html?ref=amirocms" target="_blank">Пополнить баланс</a>
            </div>
        </div>

        <h1 class="uz_tagetsms">Инструкция по использованю модуля:</h1>

        <h2 class="uz_tagetsms">Регистрация</h2>
        <ol class="uz_tagetsms">
            <li>Перейти на сайт <a href="https://sms.targetsms.ru/ru/reg.html?ref=amirocms" target="_blank">TargetSMS</a> и заполнить и отправить регистрационную форму.</li>
            <li>Дождаться, когда с вами свяжется менеджер и активирует аккаунт.</li>
        </ol>

        <h2 class="uz_tagetsms">Настройка модуля</h2>
        <ol class="uz_tagetsms">
            <li>В <a href="https://sms.targetsms.ru/ru/cabinet.html?ref=amirocms" target="_blank">личном кабинете TargetSMS</a> добавить отправителя.</li>
            <li>В панели администратора вашего сайта перейти в <a href="/_admin/srv_options.php?flt_module=##modId##&flt_owner=##section##&flt_mode=" target="_blank">модуль настроек</a>. Заполнить логин, пароль, имя отправителя и телефоны менеджеров.</li>
            <li>Отредактировать шаблоны СМС и пополнить баланс.</li>
        </ol>

        <h2 class="uz_tagetsms">Редактирование шаблонов СМС</h2>
        <ol class="uz_tagetsms">
            <li>Открыть <a href="/_admin/engine.php?mod_id=modules_templates#mid=modules_templates&header=inst_uz_targetsms_sms_templates" target="_blank">модуль шаблонов</a>.</li>
            <li>Открыть на редактирование шаблон "##template_name##".</li>
            <li>Задать или очистить шаблоны сообщений для нужных статусов.</li>
        </ol>

        <ul class="uz_tagetsms">
            <li>Для каждого статуса можно задавать 2 шаблонка - для покупателя (*_frn) и для администратора (*_adm).</li>
            <li>СМС будут отправляться для всех статусов, у которых задан непустой шаблон.</li>
            <li>Чтобы отключить отправку СМС для определенного статуса, достаточно очистить для него шаблон. Пустые сообщения - не отправляются.</li>
            <li>Для персонификации сообщений, в шаблонах можно использовать переменные с данными заказа и покупателя.</li>
            <li>Список доступных переменных приведен в шаблоне.</li>
        </ul>

        <h2 class="uz_tagetsms">Пополнение баланса</h2>
        <div class="uz_tagetsms">Пополнение баланса производится в личном кабинете TargetSMS, на <a href="https://sms.targetsms.ru/ru/cabinet/pay.html?ref=amirocms" target="_blank">соответствующей странице</a>.</div>
        <div class="uz_tagetsms">Там необходимо выбрать способ оплаты и сумму, и далее следовать мастеру оплаты.</div>
        <br>
        <h2>Системные требования</h2>
        <div class="uz_tagetsms uz_tagetsms_red">Минимальная версия библиотеки openssl: OpenSSL 0.9.8e-fips-rhel5 01 Jul 2008</div>

        <style type="text/css">
            .uz_tagetsms_buttons_box{
            	margin-top: 20px;
                margin-bottom: 20px;
            }
            .uz_targetsms_inline_btn{
                display: inline-block;
                margin-right: 20px;
                background: #f5f5f5;
                border: 1px solid #e0e0e0;
                border-radius: 3px;
                color: #666666;
                padding: 8px 15px;
                font-size: 12px;
                line-height: 20px;
                height: auto;
                font-weight: normal;
            }
            .uz_targetsms_inline_btn:hover{
                background: #f0f0f0;
                border: 1px solid #c0c0c0;
            }
            h2.uz_tagetsms{
                margin-top:10px;
                margin-bottom:10px;
            }
            ol.uz_tagetsms{
                list-style-position: inside;
                margin-top: 1em;
                margin-bottom: 1em;
            }
            ul.uz_tagetsms{
                list-style-position: inside;
                margin-top: 1em;
                margin-bottom: 1em;
                padding-left: 20px;
            }
            div.uz_tagetsms{
                font-size: 12px;
            }
            div.uz_tagetsms_red{
                color: red;
            }
            .properties_form_table{
                max-width: 1040px;
            }
        </style>
    </td>
</tr>
"-->


<!--#set var="form_buttons" value="<div id="form-buttons"></div>"-->
