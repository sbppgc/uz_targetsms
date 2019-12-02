##--
Переменные для использования в шаблоне:
##id## - номер заказа
##name## - название заказа
##status## - статус заказа
##firstname## - имя покупателя
##lastname## - фамилия покупателя
##email## - email-покупателя
##comments## - комментарий покупателя
##adm_comments## - комментарий администратора
##tracking_number## - код отслеживания
##tax## - налог
##excise_tax
##shipping_tax
##shipping## - стоимость доставки
##total## - стоимость заказа без доставки
##lang## - язык
##date_created## - дата создания
##id_user## - идентификатор покупателя
##login## - логин покупателя
##date_modified## - дата изменения
##custom_info_get_type_name## - способ доставки
##custom_info_region## - Регион
##custom_info_city## - Город
##custom_info_contact## - исходное значение телефона покупателя
##system_info_person_type## - тип лица: natural/juridical
##system_info_ip## - ip адрес покупателя
##system_info_driver## - драйвер оплаты
##system_info_fee_percent## - комиссия платежного драйвера, %
##system_info_fee_curr## - валюта комиссии платежного драйвера
##system_info_fee_const## - комиссия платежного драйвера, в валюте.
##fdate## - форматированная дата создания
##id_member## - идентификатор покупателя
##username## - логин пользователя
##phone## - номер телефона, подготовленный
##total_price_discount_abs## - стоимость товаров со скидкой
##total_price_original_abs## - стоимость товаров без скидки
##total_qty## - общее количество товаров
##total_discont_abs## - общая сумма скидки
##total_discount_percent## - общий процент скидки
##total_price_discount_with_shipping_abs## - сумма заказа с учетом доставки, со скидкой
##total_price_original_with_shipping_abs## - сумма заказа с учетом доставки, без скидки

--##

##--
Шаблоны СМС
Чтобы включить отправку СМС для определенного статуса, нужно заполнить шаблон.
Чтобы отключить - очистить. Пустые сообщения - не отправляются.
Для каждого статуса можно задавать 2 шаблонка - для покупателя (*_frn) и для администратора (*_adm).
--##

##-- Принят - покупателю --##
<!--#set var="accepted_frn" value="Заказ принят. Номер вашего заказа ##id##, сумма ##total_price_discount_abs##р.##if(shipping > 0)##, стоимость доставки ##shipping##р.##endif##"-->

##-- Принят - менеджерам --##
<!--#set var="accepted_adm" value="Поступил новый заказ номер ##id##, сумма ##total_price_discount_abs##р.##if(shipping > 0)##, стоимость доставки ##shipping##р.##endif##"-->


##-- Отменен - покупателю --##
<!--#set var="cancelled_frn" value="Ваш заказ номер ##id## отменен."-->

##-- Отменен - менеджерам --##
<!--#set var="cancelled_adm" value="Заказ номер ##id## отменен."-->


##-- Подтвержден - покупателю --##
<!--#set var="confirmed_frn" value="Ваш заказ номер ##id## подтвержден."-->

##-- Подтвержден - менеджерам --##
<!--#set var="confirmed_adm" value=""-->


##-- Отклонен - покупателю --##
<!--#set var="rejected_frn" value=""-->

##-- Отклонен - менеджерам --##
<!--#set var="rejected_adm" value=""-->


##-- В ожидании - покупателю --##
<!--#set var="pending_frn" value=""-->

##-- В ожидании - менеджерам --##
<!--#set var="pending_adm" value=""-->


##-- Оплачивается - покупателю --##
<!--#set var="checkout_frn" value=""-->

##-- Оплачивается - менеджерам --##
<!--#set var="checkout_adm" value=""-->


##-- Ожидается - покупателю --##
<!--#set var="waiting_frn" value=""-->

##-- Ожидается - менеджерам --##
<!--#set var="waiting_adm" value=""-->


##-- Отправлен - покупателю --##
<!--#set var="shipped_frn" value="Ваш заказ номер ##id## передан в службу доставки."-->

##-- Отправлен - менеджерам --##
<!--#set var="shipped_adm" value=""-->


##-- Доставлен - покупателю --##
<!--#set var="delivered_frn" value=""-->

##-- Доставлен - менеджерам --##
<!--#set var="delivered_adm" value=""-->


##-- Запрос - покупателю --##
<!--#set var="draft_frn" value=""-->

##-- Запрос - менеджерам --##
<!--#set var="draft_adm" value=""-->


##-- Запрос поставки - покупателю --##
<!--#set var="requirements_draft_frn" value=""-->

##-- Запрос поставки - менеджерам --##
<!--#set var="requirements_draft_adm" value=""-->


##-- Распечатан - покупателю --##
<!--#set var="printed_frn" value=""-->

##-- Распечатан - менеджерам --##
<!--#set var="printed_adm" value=""-->


##-- Заказ поставки подтвержден - покупателю --##
<!--#set var="requirements_accepted_frn" value=""-->

##-- Заказ поставки подтвержден - менеджерам --##
<!--#set var="requirements_accepted_adm" value=""-->


##-- Заказ поставки отменен - покупателю --##
<!--#set var="requirements_cancelled_frn" value=""-->

##-- Заказ поставки отменен - менеджерам --##
<!--#set var="requirements_cancelled_adm" value=""-->


##-- Условно оплачен - покупателю --##
<!--#set var="confirmed_conditionally_frn" value=""-->

##-- Условно оплачен - менеджерам --##
<!--#set var="confirmed_conditionally_adm" value=""-->


##-- Зачислено - покупателю --##
<!--#set var="confirmed_done_frn" value=""-->

##-- Зачислено - менеджерам --##
<!--#set var="confirmed_done_adm" value=""-->

