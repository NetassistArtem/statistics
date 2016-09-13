<?php

return [
    'adminEmail' => 'admin@example.com',
    'homeUrl' => 'statistics/charges-by-network',
    'date-before' => '2007-09-27',
    'date-before-todo' => '2008-05-30',
    'year-period-select-data' => 5,
    'years-compare' => 2,
    'colors_todo' => array(
        1 => array(100, 149, 237),
        2 => array(60, 174, 113),
        3 => array(255, 215, 0),
        4 => array(178, 34, 34),
        5 => array(105, 105, 105),
        6 => array(255,000,255)
    ),
    'colors_statistic' => array(
        1 => array(100, 149, 237),
        2 => array(60, 174, 113),
        3 => array(255, 215, 0),
        4 => array(178, 34, 34),
        5 => array(105, 105, 105),
    ),
    'users_type' =>array(
        1 => array(
            'net_id' => 101,
            'user_class' => 0,
            'net_id_operator' => '<',
            'name' => 'Домашние абоненты',
            'name_file' => 'charge_year_home'
        ),
        2 => array(
            'net_id' => 199,
            'user_class' => 1,
            'net_id_operator' => '<=',
            'name' => 'Бизнес абоненты  домосети',
            'name_file' => 'charge_year_business_homenetwork'
        ),
        3 => array(
            'net_id' => 200,
            'user_class' => 1,
            'net_id_operator' => '=',
            'name' => 'Бизнес абоненты магистральные',
            'name_file' => 'charge_year_business_trunk'
        ),
        4 => array(
            'net_id' => 199,
            'user_class' => '',
            'net_id_operator' => '<=',
            'name' => 'Домосеть',
            'name_file' => 'charge_year_homenetwork'
        ),
        5 => array(
            'net_id' => 200,
            'user_class' => '',
            'net_id_operator' => '<=',
            'name' => 'Все абоненты',
            'name_file' => 'charge_year_all'
        ),
    ),
    'todo_type' => array(
        1 => array(
            'type_id' => 1,
            'billing_name' => 'монтаж-включение',
            'name' => 'Подключения',
            'name_file' => 'connect_new'
        ),
        2 => array(
            'type_id' => 3,
            'billing_name' => 'обращение в суппорт',
            'name' => 'Обращение в суппорт',
            'name_file' => 'todo_all'
        ),
        3 => array(
            'type_id' => 8,
            'billing_name' => 'вызов на дом',
            'name' => 'Вызовы на дом',
            'name_file' => 'to_home'
        ),
        4 => array(
            'type_id' => 12,
            'billing_name' => 'монтаж - авария',
            'name' => 'Аварии',
            'name_file' => 'todo_alarm'
        ),
        5 => array(
            'type_id' => 13,
            'billing_name' => 'админ - авария',
            'name' => 'Админ-аварии',
            'name_file' => 'todo_admin_alarm'
        ),
        6 => array(
            'type_id' => 100,
            'billing_name' => 'отключения',
            'name' => 'Отключения',
            'name_file' => 'todo_disconnecting'
        )
    ),
    'todo_status' => array(
        1 => array(
            'name' => 'Поступило',
            'name_en' => 'data_income',
            'color' => array(255,128,114),
            'data' => array(
                0 => 'New',
            )
        ),
        2 => array(
            'name' => 'В работе',
            'name_en' => 'data_inwork',
            'color' => array(60,179,113),
            'data' => array(
                5 => 'Подготовить',
                6 => 'Утверждено',
                10 => 'Проверить',
                15 => 'Перезвонить (support)',
                16 => 'Перезвонить (исполн.)',
                20 => 'В очереди',
                21 => 'Забрать',
                30 => 'Уже делаем',
                40 => 'Перекур',
                42 => 'Перекур по просьбе',
                50 => 'Скоро',
                60 => 'Когда-нибудь',
                61 => 'Интересовались',
                90 => 'Готовим отчет',

            )
        ),
        3 => array(
            'name' => 'Выполнено',
            'name_en' => 'data_complete',
            'color' => array(255, 215,0),
            'data' => array(
                92 => 'отчет готов!',
                100 => 'Complete',
            )
        ),
        4 => array(
            'name' => 'Отменены',
            'name_en' => 'data_delete',
            'color' => array(100,149,237),
            'data' => array(
                110 => 'Архив',
                200 => 'Lost',
                210 => 'Не актуально',
            )
        ),
        5 => array(
            'name' => 'Дубликаты',
            'name_en' => 'data_repeat',
            'color' => array(189,183,107),
            'data' => array(
                250 => 'Дубликат',
                900 => 'Тема закрыта',
                901 => 'SPAM',
            )
        )
    ),
    'todo_support_old_query_request' => 1506, //Для тодо - Обращение в суппорт.До этой даты (15.06) включительно использоуется один запрос в базу данных после
    // этой даты другой (с использованием групп)

    'net_list' => array(
        0 => 'Все',
        1 => '1 : Русановка-нет',
        2 => '2 : Dorogozhichi',
        3 => '3 : D-Net',
        4 => '4 : Cyber-tm',
        5 => '5 : Kryshev',
        6 => '6 : Vozduh',
        7 => '7 : Охматдет',
        8 => '8 : Alfa-KPI',
        9 => '9 : Wifi-P37',
        10 => '10 : WiFi-B19',
        11 => '11 : ArtemaLAN',
        12 => '12 : WiFi-School45',
        13 => '13 : L142',
        14 => '14 : DNet-Kudri',
        15 => '15: Nesterovskiy13-LikN2',
        16 => '16 : Kuzia-V',
        17 => '17 : Kuzia-North',
        18 => '18 : Kuzia-South',
        19 => '19 : LD-Net',
        20 => '20 : Kryshev-school-298',
        21 => '21 : WebberHL',
        22 => '22 : Kuzia-Center',
        23 => '23 : Ilyinskaya',
        24 => '24 : Transport_MGMT-Cosmonova',
        25 => '25 : Transport_MGMT-MistoTV',
        26 => '26 : NLine-mgmt-74',
        27 => '27 : NLine-mgmt-75',
        28 => '28 : NLine-mgmt-76',
        29 => '29 : NLine-mgmt-77',
        30 => '30 : NLine-mgmt-78',
        75 => '75 : BZh-LAN',
        76 => '76 : Kryshev-SV14',
        78 => '78 : Kryshev-GS63',
        79 => '79 : Maxtul-Home',
        88 => '88 : Phoenix-NET',
        99 => '99 : Mini-office HL',
        100 => '100 : L-9',
        101 => '101 : Office',
        102 => '102 : Netassist-L9',
        199 => '199 : LAN-VIP',
        200 => '200 : VIP-Clients',
        201 => '201 : VPN',
        202 => '202 : Hosting',
        203 => '203 : PI-clients',
        204 => '204 : VPN Game',
        210 => '210 : AI-10G',
        300 => '300 : SUP',
        301 => '301 : SUP-ISP',
        302 => '302 : SUP-Rent',
        1000 => '1000 : other',
        13001 => '13001 : D-Net tech1',
        25000 => '25000 : test subnet',

    ),
];
