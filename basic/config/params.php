<?php

return [
    'adminEmail' => 'admin@example.com',
    'homeUrl' => 'statistics/charges-by-network',
    'date-before' => '2007-09-27',
    'date-before-todo' => '2008-05-30',
    'date-before-requests' => '2008-05-30',
    'year-period-select-data' => 5,//количество лет отображаемое по умолчанию для графиков todo
    'year-period-select-todo-time' => 3, //количество лет отображаемое по умолчанию для графиков todo-time
    'year-period-select-requests' => 2,//количество лет отображаемое по умолчанию для графиков requests
    'years-compare' => 2,
    'colors_todo' => array(
        1 => array(100, 149, 237),
        2 => array(60, 174, 113),
        3 => array(255, 215, 0),
        4 => array(178, 34, 34),
        5 => array(105, 105, 105),
        6 => array(255, 000, 255)
    ),
    'colors_statistic' => array(
        1 => array(100, 149, 237),
        2 => array(60, 174, 113),
        3 => array(255, 215, 0),
        4 => array(178, 34, 34),
        5 => array(105, 105, 105),
    ),
    'colors_requests_type' => array(
        1 => array(100, 190, 200),
        2 => array(60, 174, 113),
        3 => array(255, 215, 0),
        4 => array(178, 34, 34),
        5 => array(105, 105, 105),
    ),
    'users_type' => array(
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
    'requests_type' => array(
        1 => array(
            'name' =>'Все заявки',
            'name_en' =>'all',
            'color' => array(204, 153, 0),
        ),
        2 => array(
            'name' =>'Заявки в покрытии',
            'name_en' =>'net',
            'color' => array(255, 102, 0),

        ),
        3 => array(
            'name' =>'Подключенные домосетка',
            'name_en' =>'connect_home',
            'color' => array(51, 153 ,102),

        ),
        4 => array(
            'name' =>'Подключенные корпоративы',
            'name_en' =>'connect_corporate',
            'color' => array(0, 255, 0),

        ),
        5 => array(
            'name' =>'Все подключения',
            'name_en' =>'connect_all',
            'color' => array(204, 255, 51),

        )
    ),
    'request_org' => array(
        1 => array(
            'org_id' => array(
                7 => 'Кузя'
            ),
            'name' => 'Кузя',
            'name_en' => 'kuzia'
        ),
        2 => array(
            'org_id' => array(
                0 => 'Альфа-инет'
            ),
            'name' => 'Альфа',
            'name_en' => 'alfa'
        ),
        3 => array(
            'org_id' => array(
                11 => 'NLine'
            ),
            'name' => 'NLine',
            'name_en' => 'nline'
        ),
        4 => array(
            'org_id' => array(
                1 => 'NetAssistVAT',
                2 => 'Крышев-нет',
                3 => 'Веббер',
                4 => 'Феникс',
                5 => 'LD',
                11000 => 'City-Compass',
                6 => 'k291',
                8 => 'NetAsistNOVAT',
                9 => 'Druid-MUA',
                10 => 'Count-FOP',
                12 => 'FOP_Parnicov',
                13 => 'FOP less',
            ),
            'name' => 'Другие сети',
            'name_en' => 'other'
        ),
        5 => array(
            'org_id' => array(),
            'name' => 'Все',
            'name_en' => 'all'
        ),
        6 => array(
            'org_id' => array(
                -1 => 1,
            ),
            'name' => 'Без сетки',
            'name_en' => 'nonet'
        ),
    ),
    'todo_status' => array(
        1 => array(
            'name' => 'Поступило',
            'name_en' => 'data_income',
            'color' => array(255, 128, 114),
            'data' => array(
                0 => 'New',
            )
        ),
        2 => array(
            'name' => 'В работе',
            'name_en' => 'data_inwork',
            'color' => array(60, 179, 113),
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


            )
        ),
        3 => array(
            'name' => 'Выполнено',
            'name_en' => 'data_complete',
            'color' => array(255, 215, 0),
            'data' => array(
                90 => 'Готовим отчет',
                92 => 'отчет готов!',
                100 => 'Complete',
            )
        ),
        4 => array(
            'name' => 'Отменены',
            'name_en' => 'data_delete',
            'color' => array(100, 149, 237),
            'data' => array(
                110 => 'Архив',
                200 => 'Lost',
                210 => 'Не актуально',
            )
        ),
        5 => array(
            'name' => 'Дубликаты',
            'name_en' => 'data_repeat',
            'color' => array(189, 183, 107),
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
    'todo_status_for_time' => array(
        1 => array(
            'group_status' => 'data_inwork',
            'name' => '5,6:Подготовить',
            'name_en' => '',
            'color' => array(60, 179, 113),
            'data_id' => array(5, 6),
            'parent' => 7,

        ),
        2 => array(
            'group_status' => 'data_inwork',
            'name' => '10:Проверить',
            'name_en' => '',
            'color' => array(60, 179, 113),
            'data_id' => array(10),
            'parent' => 7,

        ),
        3 => array(
            'group_status' => 'data_inwork',
            'name' => '15:Перезвонить (support)',
            'name_en' => '',
            'color' => array(60, 179, 113),
            'data_id' => array(15),
            'parent' => 7,

        ),
        4 => array(
            'group_status' => 'data_inwork',
            'name' => '16:Перезвонить (исполн.)',
            'name_en' => '',
            'color' => array(60, 179, 113),
            'data_id' => array(16),
            'parent' => 7,

        ),
        5 => array(
            'group_status' => 'data_inwork',
            'name' => '20:В очереди',
            'name_en' => '',
            'color' => array(60, 179, 113),
            'data_id' => array(20),
            'parent' => 7,

        ),
        6 => array(
            'group_status' => 'data_inwork',
            'name' => '30-61:Уже делаем',
            'name_en' => '',
            'color' => array(60, 179, 113),
            'data_id' => array(30, 40, 42, 50, 60, 61),
            'parent' => 7,

        ),
        7 => array(
            'group_status' => 'data_inwork',
            'name' => 'Все(в работе)',
            'name_en' => '',
            'color' => array(60, 179, 113),
            'data_id' => array(5, 6, 10, 15, 16, 20, 30, 40, 42, 50, 60, 61),
            'parent' => 7,
        ),

        8 => array(
            'group_status' => 'data_complete',
            'name' => '90:Готовим отчет',
            'name_en' => '',
            'color' => array(255, 215, 0),
            'data_id' => array(90),
            'parent' => 11,

        ),
        9 => array(
            'group_status' => 'data_complete',
            'name' => '92:Отчет готов!',
            'name_en' => '',
            'color' => array(255, 215, 0),
            'data_id' => array(92),
            'parent' => 11,

        ),
        10 => array(
            'group_status' => 'data_complete',
            'name' => '100:Complete',
            'name_en' => '',
            'color' => array(255, 215, 0),
            'data_id' => array(100),
            'parent' => 11,

        ),
        11 => array('group_status' => 'data_complete',
            'name' => 'Все(выполнено)',
            'name_en' => '',
            'color' => array(255, 215, 0),
            'data_id' => array(90, 92, 100),
            'parent' => 11,
            ),


        12 => array(
            'group_status' => 'data_delete',
            'name' => '110:Архив',
            'name_en' => '',
            'color' => array(100, 149, 237),
            'data_id' => array(110),
            'parent' => 14,

        ),
        13 => array(
            'group_status' => 'data_delete',
            'name' => '200,210:Не актуально',
            'name_en' => '',
            'color' => array(100, 149, 237),
            'data_id' => array(200, 210),
            'parent' => 14,

        ),
        14 => array(
            'group_status' => 'data_delete',
            'name' => 'Все(отменены)',
            'name_en' => '',
            'color' => array(100, 149, 237),
            'data_id' => array(110, 200, 210),
            'parent' => 14,
        ),
        15 => array(
            'group_status' => 'data_repeat',
            'name' => '250:Дубликат',
            'name_en' => '',
            'color' => array(189, 183, 107),
            'data_id' => array(250),
            'parent' => 17,

        ),
        16 => array(
            'group_status' => 'data_repeat',
            'name' => '900,901:Тема закрыта',
            'name_en' => '',
            'color' => array(189, 183, 107),
            'data_id' => array(900, 901),
            'parent' => 17,

        ),
        17 => array(
            'group_status' => 'data_repeat',
            'name' => 'Все(дубликаты)',
            'name_en' => '',
            'color' => array(189, 183, 107),
            'data_id' => array(250, 900, 901),
            'parent' => 17,
        ),


    ),

    'todo_time_color' => array(
        'hours' => array(000,153,102),
        'todo' => array(255,153,000),
    ),

    'todo_time_limit' => 150, //максимальное время обработки ТОДО. ТОДО, время обработки которых выше этого предела отсекаются фильтром
    'default_value' => array(
        'todo' => array(),
        'todo_time' => array(
            'year_todo_type' => 3,
            'year_todo_status' => 8,
            'year_year' => 2016,
        )
    ),
];

