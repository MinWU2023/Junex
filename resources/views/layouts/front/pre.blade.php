<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>预览</title>
    <link type="text/css" rel="stylesheet" href="{{ asset('pre/css/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('pre/css/animate.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('pre/css/style.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('images/moban.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('tinymce/tpl/css/det_style.css') }}">
    <link href="https://fonts.googlefonts.cn/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('pre/js/jquery-1.8.3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pre/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pre/js/swiper.min.js') }}"></script>

    <script type="text/javascript">
        $(document).on("scroll",function(){
            if($(document).scrollTop()>20){
                $("header").removeClass("large").addClass("small");
            }
            else{
                $("header").removeClass("small").addClass("large");
            }
        });
    </script>
    <!--[if ie9]
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    -->
    <!--[if IE 8]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<svg xlmns="http://www.w3.org/2000/svg" version="1.1" class="hidden">
    <symbol id="more_ico_svg" viewBox="0 0 1024 1024">
        <path d="M931.469306 232.157942L544.597615 8.774288a65.125235 65.125235 0 0 0-65.295222 0L92.530694 232.157942c-20.198522 11.699144-32.597615 33.197571-32.597615 56.495866v446.667316c0 23.298295 12.399093 44.896715 32.597615 56.495866l386.871691 223.383654a65.125235 65.125235 0 0 0 65.295222 0l386.871692-223.383654c20.198522-11.699144 32.597615-33.197571 32.597614-56.495866V288.653808c-0.099993-23.298295-12.499085-44.796722-32.697607-56.495866z" fill="" p-id="8884"></path>
    </symbol>

    <symbol id="icon-arrow-nav" viewBox="0 0 1024 1024">
        <path d="M581.632 781.824L802.816 563.2H99.328a51.2 51.2 0 0 1 0-102.4h703.488l-221.184-218.624a51.2 51.2 0 0 1 0-72.192 46.592 46.592 0 0 1 68.096 0l310.272 307.2a55.296 55.296 0 0 1 0 74.752l-310.272 307.2a46.592 46.592 0 0 1-68.096 0 51.2 51.2 0 0 1 0-77.312z"  p-id="9162"></path>
    </symbol>
    <symbol id="icon-home" viewBox="0 0 1024 1024" >
        <path d="M840.192497 1024h-178.309309a64.604822 64.604822 0 0 1-64.604823-64.604822V646.06179H419.615104v311.395243a64.604822 64.604822 0 0 1-64.604822 64.604822H181.22331a64.604822 64.604822 0 0 1-64.604822-64.604822V525.250772H76.563498a58.14434 58.14434 0 0 1-58.790388-38.762893A64.604822 64.604822 0 0 1 31.340122 416.068622L470.652914 18.102917a64.604822 64.604822 0 0 1 89.800703 0l432.852309 396.673609a64.604822 64.604822 0 0 1-45.869424 109.828198h-44.577327v436.728598a64.604822 64.604822 0 0 1-62.666678 62.666678zM422.199297 585.979305h179.601406a64.604822 64.604822 0 0 1 64.604822 64.604822v313.333388h175.725117V465.168287h109.182149L515.876289 64.618389 76.563498 462.584094h107.890053v501.333421h178.955358v-310.749195a64.604822 64.604822 0 0 1 58.790388-67.189015z" p-id="2464"></path>
    </symbol>
    <symbol id="icon-product" viewBox="0 0 1024 1024" >
        <path d="M491.093 444.587c-21.76 0-42.538-4.31-58.624-12.246L112.085 274.688c-21.93-10.795-34.56-28.117-34.688-47.488-0.128-19.627 12.587-37.376 34.902-48.725L436.053 14.08C453.12 5.419 475.093 0.683 498.005 0.683c21.76 0 42.539 4.352 58.624 12.245l320.384 157.653c21.931 10.795 34.56 28.16 34.688 47.531 0.128 19.627-12.586 37.376-34.901 48.683L553.045 431.189c-17.066 8.662-39.04 13.44-61.994 13.44zM135.68 226.688l320.427 157.696c8.704 4.267 21.418 6.741 34.901 6.741 14.464 0 28.203-2.773 37.76-7.637l323.755-164.395a22.699 22.699 0 0 0 0.81-0.426L532.907 61.013c-8.704-4.266-21.462-6.784-34.944-6.784-14.422 0-28.16 2.774-37.718 7.638L136.533 226.219a98.816 98.816 0 0 0-0.81 0.426z m288.853 796.672c-11.093 0-22.613-2.944-34.432-8.661l-0.682-0.384-286.294-150.187c-34.261-16.939-60.074-53.205-60.074-84.48V374.741c0-28.373 20.864-48.981 49.536-48.981 11.093 0 22.613 2.901 34.432 8.661l0.682 0.342 286.294 150.186c34.261 16.939 60.074 53.206 60.074 84.523v404.907c0 28.373-20.821 48.981-49.536 48.981z m-10.624-56.661c2.688 1.28 4.864 2.048 6.571 2.517V569.515c0-8.662-12.075-27.648-30.379-36.608l-0.682-0.342L103.21 382.38a35.84 35.84 0 0 0-6.571-2.475v399.701c0 8.662 12.117 27.648 30.379 36.608l0.682 0.342L413.91 966.74z m164.566 56.661c-28.715 0-49.494-20.608-49.494-48.981V569.472c0-31.317 25.771-67.584 60.032-84.48l286.976-150.57c11.776-5.76 23.339-8.662 34.432-8.662 28.672 0 49.494 20.608 49.494 48.981v404.864c0 31.318-25.771 67.584-60.032 84.48L612.907 1014.7a78.592 78.592 0 0 1-34.432 8.661zM899.84 382.379L612.95 532.907c-18.305 8.96-30.422 27.946-30.422 36.608v399.701a36.992 36.992 0 0 0 6.613-2.517L876.032 816.17c18.261-8.918 30.379-27.904 30.379-36.566V379.904a36.395 36.395 0 0 0-6.571 2.475z" p-id="3372"></path>
    </symbol>
    <symbol id="con-mes" viewBox="0 0 1024 1024" >
        <path d="M832 128H192c-70.656 0-128 57.344-128 128v384c0 70.656 57.344 128 128 128h127.808v65.408c0 24 13.44 45.568 34.944 56.192 8.896 4.288 18.368 6.464 27.776 6.464 13.504 0 26.88-4.416 38.08-12.992L570.048 768H832c70.656 0 128-57.344 128-128V256c0-70.656-57.344-128-128-128z m64 512c0 35.392-28.608 64-64 64l-272.576-0.064c-7.04 0-13.888 2.304-19.456 6.592L383.744 833.472v-97.536c0-17.664-14.336-31.936-31.936-31.936H192c-35.392 0-64-28.608-64-64V256c0-35.392 28.608-64 64-64h640c35.392 0 64 28.608 64 64v384zM320 384c-35.392 0-64 28.608-64 64 0 35.392 28.608 64 64 64 35.392 0 64-28.608 64-64 0-35.392-28.608-64-64-64z m192 0c-35.392 0-64 28.608-64 64 0 35.392 28.608 64 64 64 35.392 0 64-28.608 64-64 0-35.392-28.608-64-64-64z m192 0c-35.392 0-64 28.608-64 64 0 35.392 28.608 64 64 64 35.392 0 64-28.608 64-64 0-35.392-28.608-64-64-64z" p-id="7771"></path>
    </symbol>
    <symbol id="con-whatsapp" viewBox="0 0 1024 1024" >
        <path d="M713.5 599.9c-10.9-5.6-65.2-32.2-75.3-35.8-10.1-3.8-17.5-5.6-24.8 5.6-7.4 11.1-28.4 35.8-35 43.3-6.4 7.4-12.9 8.3-23.8 2.8-64.8-32.4-107.3-57.8-150-131.1-11.3-19.5 11.3-18.1 32.4-60.2 3.6-7.4 1.8-13.7-1-19.3-2.8-5.6-24.8-59.8-34-81.9-8.9-21.5-18.1-18.5-24.8-18.9-6.4-0.4-13.7-0.4-21.1-0.4-7.4 0-19.3 2.8-29.4 13.7-10.1 11.1-38.6 37.8-38.6 92s39.5 106.7 44.9 114.1c5.6 7.4 77.7 118.6 188.4 166.5 70 30.2 97.4 32.8 132.4 27.6 21.3-3.2 65.2-26.6 74.3-52.5 9.1-25.8 9.1-47.9 6.4-52.5-2.7-4.9-10.1-7.7-21-13z m211.7-261.5c-22.6-53.7-55-101.9-96.3-143.3-41.3-41.3-89.5-73.8-143.3-96.3C630.6 75.7 572.2 64 512 64h-2c-60.6 0.3-119.3 12.3-174.5 35.9-53.3 22.8-101.1 55.2-142 96.5-40.9 41.3-73 89.3-95.2 142.8-23 55.4-34.6 114.3-34.3 174.9 0.3 69.4 16.9 138.3 48 199.9v152c0 25.4 20.6 46 46 46h152.1c61.6 31.1 130.5 47.7 199.9 48h2.1c59.9 0 118-11.6 172.7-34.3 53.5-22.3 101.6-54.3 142.8-95.2 41.3-40.9 73.8-88.7 96.5-142 23.6-55.2 35.6-113.9 35.9-174.5 0.3-60.9-11.5-120-34.8-175.6z m-151.1 438C704 845.8 611 884 512 884h-1.7c-60.3-0.3-120.2-15.3-173.1-43.5l-8.4-4.5H188V695.2l-4.5-8.4C155.3 633.9 140.3 574 140 513.7c-0.4-99.7 37.7-193.3 107.6-263.8 69.8-70.5 163.1-109.5 262.8-109.9h1.7c50 0 98.5 9.7 144.2 28.9 44.6 18.7 84.6 45.6 119 80 34.3 34.3 61.3 74.4 80 119 19.4 46.2 29.1 95.2 28.9 145.8-0.6 99.6-39.7 192.9-110.1 262.7z" p-id="2166"></path>
    </symbol>
    <symbol id="con-email" viewBox="0 0 1024 1024" >
        <path d="M860.7 192.6h-697c-27.5 0-49.8 22.3-49.8 49.8V780c0 27.5 22.3 49.8 49.8 49.8h697c3.7 0 7.4-0.4 11-1.2 6.3 0 12.3-2.3 16.9-6.5v-1.5c13.5-9.1 21.7-24.3 21.9-40.6V242.3c0-27.5-22.3-49.7-49.8-49.7zM512.2 556L169.9 248.6h686.6L512.2 556zM163.7 309.8l229.5 206.4-229.5 228.7V309.8z m266.6 238.7l66.2 59.5c9.4 8.4 23.7 8.4 33.1 0l70.5-63 215.8 235H198.8l231.5-231.5z m206.3-36.8l224-199.1v443.1l-224-244z m0 0" p-id="2380"></path>
    </symbol>
    <symbol id="con-tel" viewBox="0 0 1024 1024" >
        <path d="M506.189667 655.677307c3.924379 7.848759 11.773138 11.773138 19.621896 15.697517 19.621896 15.697517 39.243793 11.773138 47.092551 7.848759l39.243793-58.865689 0 0c7.848759-7.848759 15.697517-11.773138 23.546276-19.621896 7.848759-3.924379 15.697517-7.848759 27.470655-7.848759l0 0c7.848759-3.924379 19.621896 0 27.470655 0l3.924379 0c7.848759 3.924379 15.697517 7.848759 23.546276 15.697517L863.306134 722.390731l3.924379 0c7.848759 7.848759 11.773138 15.697517 15.697517 23.546276l0 0c3.924379 7.848759 7.848759 19.621896 7.848759 27.470655 0 11.773138 0 23.546276-3.924379 31.395034l0 0c-3.924379 11.773138-11.773138 19.621896-19.621896 27.470655-7.848759 7.848759-19.621896 15.697517-35.319413 23.546276l0 3.924379c-11.773138 7.848759-31.395034 15.697517-47.092551 19.621896-82.411965 27.470655-168.747285 23.546276-251.158227-3.924379-7.848759-3.924379-19.621896-7.848759-27.470655-11.773138l0-62.790068c15.697517 3.924379 31.395034 11.773138 47.092551 15.697517 70.638827 23.546276 145.20101 31.395034 211.915457 7.848759 15.697517-3.924379 27.470655-11.773138 35.319413-15.697517l3.924379-3.924379c7.848759-3.924379 15.697517-11.773138 23.546276-15.697517 0-3.924379 3.924379-3.924379 3.924379-7.848759l0 0 0 0c0 0 0 0 0-3.924379 0-3.924379 0-3.924379 0-3.924379l0 0c0-3.924379-3.924379-3.924379-3.924379-3.924379l0-3.924379L682.785711 651.752928l0 0c-3.924379 0-3.924379 0-7.848759 0l0 0-3.924379 0 0 0c-3.924379 0-3.924379 0-3.924379 0l0 0 0 0c-3.924379 0-3.924379 3.924379-3.924379 3.924379l0 0 0 0-47.092551 62.790068c0 3.924379-3.924379 7.848759-7.848759 7.848759 0 0-47.092551 31.395034-102.032838 3.924379L506.189667 655.677307zM298.198589 153.35983l113.805976 145.20101 0 3.924379c3.924379 7.848759 7.848759 15.697517 11.773138 23.546276 0 7.848759 3.924379 19.621896 0 27.470655 0 11.773138-3.924379 19.621896-7.848759 27.470655l0 3.924379c-7.848759 7.848759-11.773138 11.773138-19.621896 19.621896l-3.924379 0-54.94131 39.243793c-3.924379 7.848759-7.848759 27.470655 7.848759 47.092551 23.546276 35.319413 51.016931 70.638827 82.410941 98.108458l0 0 0 0c23.546276 23.546276 51.016931 47.092551 78.487585 66.714448l0 74.563206c-3.924379-3.924379-11.773138-7.848759-15.697517-11.773138-39.243793-27.470655-74.563206-54.94131-105.957217-86.335321l0 0c-31.395034-31.395034-62.790068-66.714448-86.335321-105.957217-47.092551-62.790068-7.848759-117.730355-7.848759-117.730355 0-3.924379 3.924379-3.924379 7.848759-7.848759l58.865689-43.168172 3.924379-3.924379c0 0 0 0 3.924379 0l0-3.924379c0 0 0 0 0-3.924379l0-3.924379c0-3.924379 0-3.924379 0-3.924379l0 0 0 0L251.107061 188.67822l0 0c-3.924379 0-3.924379 0-3.924379-3.924379l-3.924379 0c0 0 0 0-3.924379 0l-3.924379 0 0 0c-3.924379 0-3.924379 3.924379-7.848759 3.924379-3.924379 7.848759-11.773138 15.697517-15.697517 23.546276-7.848759 11.773138-15.697517 23.546276-19.621896 39.243793-23.546276 66.714448-15.697517 141.27663 7.848759 211.915457 23.546276 78.487585 74.563206 153.049768 137.352251 215.839837 51.016931 51.016931 105.957217 94.184079 168.747285 121.654734l0 62.790068c-78.487585-31.395034-149.125389-82.410941-211.915457-141.27663-66.714448-70.638827-121.654734-153.049768-153.049768-239.386112-27.470655-82.410941-31.395034-168.747285-3.924379-251.158227 7.848759-19.621896 15.697517-35.319413 23.546276-47.092551l0 0 0 0c7.848759-15.697517 15.697517-27.470655 23.546276-35.319413 7.848759-7.848759 15.697517-15.697517 27.470655-19.621896l3.924379 0c7.848759-3.924379 15.697517-3.924379 27.470655-3.924379 11.773138 0 19.621896 3.924379 27.470655 7.848759l3.924379 0L298.198589 153.35983zM298.198589 153.35983 298.198589 153.35983 298.198589 153.35983 298.198589 153.35983zM298.198589 153.35983 298.198589 153.35983 298.198589 153.35983 298.198589 153.35983z" p-id="3578"></path>
    </symbol>
    <symbol id="con-skype" viewBox="0 0 1024 1024" >
        <path d="M352 128c-123.36 0-224 100.64-224 224 0 32.992 10.112 63.616 23.008 92A368.896 368.896 0 0 0 144 512c0 202.88 165.12 368 368 368 23.36 0 45.888-2.88 68-7.008 28.384 12.896 59.008 23.008 92 23.008 123.36 0 224-100.64 224-224 0-32.992-10.112-63.616-23.008-92 4.16-22.112 7.008-44.64 7.008-68 0-202.88-165.12-368-368-368-23.36 0-45.888 2.88-68 7.008C415.616 138.112 384.992 128 352 128z m0 64c27.616 0 53.376 6.72 76 19.008a32 32 0 0 0 22.016 2.976A306.784 306.784 0 0 1 512 208c168.256 0 304 135.744 304 304 0 21.376-1.888 41.888-6.016 62.016a32 32 0 0 0 3.008 21.984c12.256 22.624 19.008 48.384 19.008 76 0 88.736-71.264 160-160 160-27.616 0-53.376-6.72-76-19.008a32 32 0 0 0-22.016-2.976A306.784 306.784 0 0 1 512 816 303.552 303.552 0 0 1 208 512c0-21.376 1.888-41.888 6.016-62.016a32 32 0 0 0-3.008-21.984A158.592 158.592 0 0 1 192 352c0-88.736 71.264-160 160-160z m155.008 100.992c-79.136 0-164 33.504-164 123.008 0 43.136 15.232 88.736 100 110.016l105.984 25.984c31.872 7.872 40 25.888 40 42.016 0 26.88-26.624 52.992-74.976 52.992-94.528 0-82.4-72-133.024-72-22.72 0-39.008 15.616-39.008 37.984 0 43.648 53.632 101.024 172.032 101.024 112.608 0 168-54.4 168-127.04 0-46.976-21.632-96-107.008-114.976l-78.016-18.016c-29.632-6.72-64-15.104-64-42.976 0-28 23.744-48 67.008-48 87.136 0 79.744 60 123.008 60 22.72 0 41.984-12.992 41.984-36 0-53.76-85.12-94.016-157.984-94.016z" p-id="10267"></path>
    </symbol>
    <symbol id="con-code" viewBox="0 0 1024 1024" >
        <path d="M112 195.84A83.84 83.84 0 0 1 195.84 112h202.992a83.84 83.84 0 0 1 83.84 83.84v202.992a83.84 83.84 0 0 1-83.84 83.84H195.84A83.84 83.84 0 0 1 112 398.832V195.84zM195.84 176A19.84 19.84 0 0 0 176 195.84v202.992c0 10.96 8.88 19.84 19.84 19.84h202.992a19.84 19.84 0 0 0 19.84-19.84V195.84A19.84 19.84 0 0 0 398.832 176H195.84z m345.488 19.84A83.84 83.84 0 0 1 625.168 112H828.16A83.84 83.84 0 0 1 912 195.84v202.992a83.84 83.84 0 0 1-83.84 83.84H625.184a83.84 83.84 0 0 1-83.84-83.84V195.84z m83.84-19.84a19.84 19.84 0 0 0-19.84 19.84v202.992c0 10.96 8.88 19.84 19.84 19.84H828.16A19.84 19.84 0 0 0 848 398.832V195.84A19.84 19.84 0 0 0 828.16 176H625.184zM112 625.168a83.84 83.84 0 0 1 83.84-83.84h202.992a83.84 83.84 0 0 1 83.84 83.84V828.16A83.84 83.84 0 0 1 398.832 912H195.84A83.84 83.84 0 0 1 112 828.16V625.184z m83.84-19.84a19.84 19.84 0 0 0-19.84 19.84V828.16c0 10.944 8.88 19.824 19.84 19.824h202.992a19.84 19.84 0 0 0 19.84-19.84V625.184a19.84 19.84 0 0 0-19.84-19.84H195.84z m345.488-32a32 32 0 0 1 32-32h88.16a32 32 0 0 1 32 32v86.832h49.088v-86.832a32 32 0 0 1 32-32h95.84a32 32 0 0 1 0 64h-63.84v86.832a32 32 0 0 1-32 32h-113.072a32 32 0 0 1-32-32v-86.832h-24.16v92.592a32 32 0 1 1-64 0v-124.592z m329.088 54.256a32 32 0 0 1 32 32v53.184a32 32 0 0 1-64 0v-53.184a32 32 0 0 1 32-32z m-240.912 150.832a32 32 0 0 1 32-32h134.16a32 32 0 0 1 0 64h-102.16v29.92H838.4v-21.184a32 32 0 0 1 64 0v53.184a32 32 0 0 1-32 32H661.504a32 32 0 0 1-32-32v-93.92z m-56.16-12.832a32 32 0 0 1 32 32v74.752a32 32 0 1 1-64 0v-74.752a32 32 0 0 1 32-32z" p-id="2649"></path>
    </symbol>
    <symbol id="con-add" viewBox="0 0 1024 1024" >
        <path d="M877.216 491.808M895.904 448c0-212.064-171.936-384-384-384-212.064 0-384 171.936-384 384 0 104.672 42.016 199.456 109.92 268.736L237.664 716.736l1.568 1.568c0.768 0.768 1.536 1.568 2.336 2.336l217.12 217.12c29.376 29.376 76.992 29.376 106.368 0l217.12-217.12c0.768-0.768 1.568-1.536 2.336-2.336l1.568-1.568-0.16 0C853.888 647.456 895.904 552.672 895.904 448zM565.088 847.36c-53.12 53.12-53.152 53.248-106.368 0L285.76 673.472C228 615.648 191.904 536.224 191.904 448c0-176.736 143.264-320 320-320 176.736 0 320 143.264 320 320 0 88.224-36.096 167.648-93.856 225.472L565.088 847.36zM512 256c-106.048 0-192 85.952-192 192s85.952 192 192 192 192-85.952 192-192S618.048 256 512 256zM512 576c-70.688 0-128-57.312-128-128s57.312-128 128-128 128 57.312 128 128S582.688 576 512 576z" p-id="3352"></path>
    </symbol>
    <symbol id="icon-im" viewBox="0 0 1024 1024" >
        <path d="M279.499 275C251.102 275 228 298.095 228 326.483 228 354.889 251.102 378 279.499 378 307.897 378 331 354.89 331 326.483c0.001-28.389-23.103-51.483-51.501-51.483z m143.018 0C394.111 275 371 298.095 371 326.483 371 354.889 394.11 378 422.517 378 450.905 378 474 354.89 474 326.483 474 298.094 450.905 275 422.517 275z m142.001 5C536.111 280 513 303.112 513 331.518 513 359.906 536.11 383 564.518 383 592.905 383 616 359.906 616 331.518 616 303.111 592.906 280 564.518 280z m337.218 93.499H799.634V156.266C799.634 94.914 749.636 45 688.179 45h-531.76C94.983 45 45 94.913 45 156.266v358.177c0 60.704 48.929 110.211 109.473 111.25l-1.19 159.84 231.09-159.354v126.426c0 51.892 42.288 94.109 94.265 94.109h239.477L909.901 979l-0.942-132.56C957.573 842.744 996 802.07 996 752.605V467.604c0-51.89-42.286-94.105-94.264-94.105zM368.253 571.03L208.973 681l0.816-109.97H156.77c-31.303 0-56.771-25.474-56.771-56.787V155.79C100 124.476 125.467 99 156.771 99h531.424C719.517 99 745 124.476 745 155.79v358.453c0 31.313-25.483 56.788-56.805 56.788H368.253zM941 752.934c0 21.851-17.774 39.628-39.62 39.628h-47.764l0.602 82.438-119.309-82.438H478.622c-21.847 0-39.622-17.777-39.622-39.628v-127.03h248.992c61.408 0 111.366-49.97 111.366-111.388V428h102.021C923.226 428 941 445.777 941 467.627v285.307z" p-id="5831"></path>
    </symbol>
    <symbol id="icon-whatsapp" viewBox="0 0 1024 1024" >
        <path d="M713.5 599.9c-10.9-5.6-65.2-32.2-75.3-35.8-10.1-3.8-17.5-5.6-24.8 5.6-7.4 11.1-28.4 35.8-35 43.3-6.4 7.4-12.9 8.3-23.8 2.8-64.8-32.4-107.3-57.8-150-131.1-11.3-19.5 11.3-18.1 32.4-60.2 3.6-7.4 1.8-13.7-1-19.3-2.8-5.6-24.8-59.8-34-81.9-8.9-21.5-18.1-18.5-24.8-18.9-6.4-0.4-13.7-0.4-21.1-0.4-7.4 0-19.3 2.8-29.4 13.7-10.1 11.1-38.6 37.8-38.6 92s39.5 106.7 44.9 114.1c5.6 7.4 77.7 118.6 188.4 166.5 70 30.2 97.4 32.8 132.4 27.6 21.3-3.2 65.2-26.6 74.3-52.5 9.1-25.8 9.1-47.9 6.4-52.5-2.7-4.9-10.1-7.7-21-13z m211.7-261.5c-22.6-53.7-55-101.9-96.3-143.3-41.3-41.3-89.5-73.8-143.3-96.3C630.6 75.7 572.2 64 512 64h-2c-60.6 0.3-119.3 12.3-174.5 35.9-53.3 22.8-101.1 55.2-142 96.5-40.9 41.3-73 89.3-95.2 142.8-23 55.4-34.6 114.3-34.3 174.9 0.3 69.4 16.9 138.3 48 199.9v152c0 25.4 20.6 46 46 46h152.1c61.6 31.1 130.5 47.7 199.9 48h2.1c59.9 0 118-11.6 172.7-34.3 53.5-22.3 101.6-54.3 142.8-95.2 41.3-40.9 73.8-88.7 96.5-142 23.6-55.2 35.6-113.9 35.9-174.5 0.3-60.9-11.5-120-34.8-175.6z m-151.1 438C704 845.8 611 884 512 884h-1.7c-60.3-0.3-120.2-15.3-173.1-43.5l-8.4-4.5H188V695.2l-4.5-8.4C155.3 633.9 140.3 574 140 513.7c-0.4-99.7 37.7-193.3 107.6-263.8 69.8-70.5 163.1-109.5 262.8-109.9h1.7c50 0 98.5 9.7 144.2 28.9 44.6 18.7 84.6 45.6 119 80 34.3 34.3 61.3 74.4 80 119 19.4 46.2 29.1 95.2 28.9 145.8-0.6 99.6-39.7 192.9-110.1 262.7z" p-id="2166"></path>
    </symbol>
    <symbol id="fixed-email-close" viewBox="0 0 800 800">
        <g transform="matrix(1.000730037689209,0,0,1.0236200094223022,399,310.5)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-255.25,-31.75 C-255.25,-31.75 255.2519989013672,-31.746999740600586 255.2519989013672,-31.746999740600586"></path></g></g><g transform="matrix(1,0,0,1,400,329.531005859375)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path fill="rgb(255,255,255)" fill-opacity="1" d=" M-0.5,127 C-0.5,127 -236.5,-33.5 -236.5,-33.5 C-236.5,-33.5 -236,287 -236,287 C-236,287 234.5,287 234.5,287 C234.5,287 234.5,-33 234.5,-33 C234.5,-33 -0.5,127 -0.5,127z"></path><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-0.5,127 C-0.5,127 -236.5,-33.5 -236.5,-33.5 C-236.5,-33.5 -236,287 -236,287 C-236,287 234.5,287 234.5,287 C234.5,287 234.5,-33 234.5,-33 C234.5,-33 -0.5,127 -0.5,127z"></path></g></g><g transform="matrix(1,0,0,1,399,593.875)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path fill-opacity="1" d=" M-156,28.5 C-156,28.5 -156,-142 -156,-142 C-156,-142 155,-142 155,-142 C155,-142 155,27 155,27"></path><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-156,28.5 C-156,28.5 -156,-142 -156,-142 C-156,-142 155,-142 155,-142 C155,-142 155,27 155,27"></path></g><g opacity="1" transform="matrix(0.9261299967765808,0,0,1,0,0)"><path fill-opacity="1" d=" M-124,-21 C-124,-21 -1,-21 -1,-21 M-124,-83 C-124,-83 118,-83 118,-83"></path><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-124,-21 C-124,-21 -1,-21 -1,-21 M-124,-83 C-124,-83 118,-83 118,-83"></path></g></g><g transform="matrix(1,0,0,1,400,329.531005859375)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path fill-opacity="1" d=" M-0.5,127 C-0.5,127 -236.5,-33.5 -236.5,-33.5 C-236.5,-33.5 -236,287 -236,287 C-236,287 234.5,287 234.5,287 C234.5,287 234.5,-33 234.5,-33 C234.5,-33 -0.5,127 -0.5,127z"></path><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-0.5,127 C-0.5,127 -236.5,-33.5 -236.5,-33.5 C-236.5,-33.5 -236,287 -236,287 C-236,287 234.5,287 234.5,287 C234.5,287 234.5,-33 234.5,-33 C234.5,-33 -0.5,127 -0.5,127z"></path></g></g>
    </symbol>
    <symbol id="fixed-email-open" viewBox="0 0 800 800">
        <g transform="matrix(1.000730037689209,0,0,1.0236200094223022,399,310.5)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-255.25,-31.75 C-255.25,-31.75 255.2519989013672,-31.746999740600586 255.2519989013672,-31.746999740600586"></path></g></g><g transform="matrix(1,0,0,1,400,329.531005859375)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path fill="rgb(255,255,255)" fill-opacity="1" d=" M21.8818416595459,-207.9999237060547 C21.8818416595459,-207.9999237060547 -236.5,-33.5 -236.5,-33.5 C-236.5,-33.5 -236,287 -236,287 C-236,287 234.5,287 234.5,287 C234.5,287 234.5,-33 234.5,-33 C234.5,-33 21.8818416595459,-207.9999237060547 21.8818416595459,-207.9999237060547z"></path><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M21.8818416595459,-207.9999237060547 C21.8818416595459,-207.9999237060547 -236.5,-33.5 -236.5,-33.5 C-236.5,-33.5 -236,287 -236,287 C-236,287 234.5,287 234.5,287 C234.5,287 234.5,-33 234.5,-33 C234.5,-33 21.8818416595459,-207.9999237060547 21.8818416595459,-207.9999237060547z"></path></g></g><g transform="matrix(1,0,0,1,399,327.875)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path fill-opacity="1" d=" M-156,28.5 C-156,28.5 -156,-142 -156,-142 C-156,-142 155,-142 155,-142 C155,-142 155,27 155,27"></path><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-156,28.5 C-156,28.5 -156,-142 -156,-142 C-156,-142 155,-142 155,-142 C155,-142 155,27 155,27"></path></g><g opacity="1" transform="matrix(0.9261299967765808,0,0,1,0,0)"><path fill="rgb(255,255,255)" fill-opacity="1" d=" M-124,-21 C-124,-21 -1,-21 -1,-21 M-124,-83 C-124,-83 118,-83 118,-83"></path><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-124,-21 C-124,-21 -1,-21 -1,-21 M-124,-83 C-124,-83 118,-83 118,-83"></path></g></g><g transform="matrix(1,0,0,1,400,329.531005859375)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path fill-opacity="1" d=" M-0.5,127 C-0.5,127 -236.5,-33.5 -236.5,-33.5 C-236.5,-33.5 -236,287 -236,287 C-236,287 234.5,287 234.5,287 C234.5,287 234.5,-33 234.5,-33 C234.5,-33 -0.5,127 -0.5,127z"></path><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="3" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="40" d=" M-0.5,127 C-0.5,127 -236.5,-33.5 -236.5,-33.5 C-236.5,-33.5 -236,287 -236,287 C-236,287 234.5,287 234.5,287 C234.5,287 234.5,-33 234.5,-33 C234.5,-33 -0.5,127 -0.5,127z"></path></g></g>
    </symbol>
</svg>
<header class="large">
    <div class="top_section">
        <div class="container clearfix">
            <div class="top_con">
                <a href="#"><svg class="icon"><use xlink:href="#con-email"></use></svg>Email : jane.tang@nokelab.com</a>
                <a href="#"><svg class="icon"><use xlink:href="#con-tel"></use></svg>Tel :+86 13373847308</a>
            </div>
            <div class="top_r">
                <div class="top_sns">
                    <a href="#"><img src="/pre/images/sns_f.png" alt=""/></a>
                    <a href="#"><img src="/pre/images/sns_t.png" alt=""/></a>
                    <a href="#"><img src="/pre/images/sns_ins.png" alt=""/></a>
                    <a href="#"><img src="/pre/images/sns_p.png" alt=""/></a>
                    <a href="#"><img src="/pre/images/sns_t.png" alt=""/></a>
                </div>
                <div class="language">
                    <p><img src="/pre/images/en.jpg" alt=""/>English<i class="fa fa-angle-down"></i></p>
                    <div class="language_ul">
                        <ul>
                            <li class="active"><a href="#"><img src="/pre/images/en.jpg" alt=""/>English</a></li>
                            <li><a href="#"><img src="/pre/images/en.jpg" alt=""/>English</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nav_section">
        <div class="container">
            <div class="main">
                <h1><a href="#" id="logo"><img src="/pre/images/logo.png" alt="#"></a></h1>
                <div class="nav_r">
                    <div class="header-navigation">
                        <nav class="main-navigation">
                            <div class="main-navigation-inner">
                                <div class="hidden_web nav_con clearfix">
                                    <a href="#">+86 19956450605</a>
                                    <a href="#" class="email_btn">Get A Quote</a>
                                </div>
                                <ul id="menu-main-menu" class="main-menu clearfix">
                                    <li class="active"><a href="#">Home</a></li>
                                    <li class="menu-children"><a href="#">About Us</a>
                                        <ul class="sub-menu">
                                            <li><a href="#" class="title">Our Honor</a></li>
                                            <li><a href="#" class="title">Our Factory</a></li>
                                            <li><a href="#" class="title">Our Team</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-children"><a href="#">Products</a>
                                        <ul class="sub-menu">
                                            <li class="menu-children">
                                                <a href="#" class="title">Rice Sorting</a>
                                                <ul class="sub-menu">
                                                    <li><a href="#" >Metal Crush Machine</a></li>
                                                    <li><a href="#" >Aluminium Extrusion Machine</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-children">
                                                <a href="#" class="title">Rice Sorting</a>
                                                <ul class="sub-menu">
                                                    <li><a href="#" >Metal Crush Machine</a></li>
                                                    <li><a href="#" >Aluminium Extrusion Machine</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-children">
                                                <a href="#" class="title">Rice Sorting</a>
                                                <ul class="sub-menu">
                                                    <li><a href="#" >Metal Crush Machine</a></li>
                                                    <li><a href="#" >Aluminium Extrusion Machine</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-children">
                                                <a href="#" class="title">Rice Sorting</a>
                                                <ul class="sub-menu">
                                                    <li><a href="#" >Metal Crush Machine</a></li>
                                                    <li><a href="#" >Aluminium Extrusion Machine</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-children">
                                                <a href="#" class="title">Rice Sorting</a>
                                                <ul class="sub-menu">
                                                    <li><a href="#" >Metal Crush Machine</a></li>
                                                    <li><a href="#" >Aluminium Extrusion Machine</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Download</a></li>
                                    <li><a href="#">News</a></li>
                                    <li><a href="#">Contact us</a></li>
                                </ul>
                                <div class="mob_language clearfix">
                                    <p>Please select your language :</p>
                                    <a href="#">EN</a>
                                    <a href="#">CN</a>
                                </div>
                                <div class="mob_sns">
                                    <p>social sharing :</p>
                                    <a href="#"><img src="/pre/images/sns_f.png" alt=""></a>
                                    <a href="#"><img src="/pre/images/sns_t.png" alt=""></a>
                                    <a href="#"><img src="/pre/images/sns_ins.png" alt=""></a>
                                    <a href="#"><img src="/pre/images/sns_p.png" alt=""></a>
                                    <a href="#"><img src="/pre/images/sns_t.png" alt=""></a>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="search_section">
                        <i class="ico_search"></i>
                        <div class="search_input">
                            <div class="close-search"><i class="fa fa-close"></i></div>
                            <div class="search_title">What Are You Looking For?</div>
                            <form>
                                <div class="search_main">
                                    <input name="search_keyword" onkeydown="javascript:enterIn(event);" type="text" class="form-control" value="Search..." onfocus="if(this.value=='Search...'){this.value='';}" onblur="if(this.value==''){this.value='Search...';}" placeholder="Search...">
                                    <input type="submit" class="search_btn btn_search1" value="">
                                </div>
                            </form>
                            <div class="search_tags">
                                <a href="#">Tags 01</a>
                                <a href="#">Tags 02</a>
                                <a href="#">Tags 03</a>
                                <a href="#">Tags 04</a>
                            </div>
                        </div>
                    </div>
                    <div class="top_overly"></div>
                </div>
            </div>
        </div>
        <div id="menu-mobile" class="hidden_web">
            <div class="mob_logo hidden_web"><a href="#"><img src="/pre/images/logo.png" alt="#"></a></div>
            <span class="btn-nav-mobile open-menu"><i></i><span></span></span>
        </div>
    </div>
</header>
<div class="height"></div>
<!--n_main-->

<div class="mbx_section">
    <div class="container clearfix">
        <div class="n_title">products</div>
        <div class="mbx">
            <a href="#"><span class="fa fa-home"></span>Home</a>
            <i class="fa fa-angle-right"></i>
            <h2>Products</h2>
        </div>
    </div>
</div>
<div class="pro_page">
    <div class="container">
        <div class="pro_main">
            <div class="col-md-5 col-xs-12 prom_img">
                <div class="swiper zoom-section" id="pro_img_gallery">
                    <div id="anypos"></div>
                    <div class="swiper-wrapper zoom-small-image">
                        @isset($product->video)
                        <div class="swiper-slide" style="background:url(/{{$product->productImages[0]->path}}) no-repeat center center;"><iframe width="582" height="540" src="{{$product->video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        @endif
                        @foreach($product->productImages as $key => $productImage)
                            <div class="swiper-slide"><a href="/{{$productImage->path}}" class="cloud-zoom" rel="position:'inside',showTitle:false,adjustX:-4,adjustY:-4"><img src="/{{$productImage->path}}" alt="" /></a></div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper" id="pro_img_thumbs">
                    <div class="swiper-wrapper">
                        @isset($product->video)
                        <div class="swiper-slide sp-video-icon"><img src="/{{$product->productImages[0]->path}}" alt=""/></div>
                        @endif
                        @foreach($product->productImages as $key => $productImage)
                            <div class="swiper-slide"><img src="/{{$productImage->path}}" alt=""/></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <script language="javascript">
                var gallerySwiper = new Swiper('#pro_img_gallery',{
                    autoHeight: true,
                    effect : 'fade',
                    thumbs: {
                        swiper: {
                            el: '#pro_img_thumbs',
                            spaceBetween: 5,
                            slidesPerView: 5,
                            watchSlidesVisibility: true,
                        },
                        autoScrollOffset: 1,
                    }
                })
            </script>
            <div class="main_text">
                <div class="pro_table">
                    <h1 class="pro_main_title">{!! $product->name !!}</h1>
                    <div class="pro_main_text clearfix">{!! $product->brief_content !!}</div>
                    <ul class="clearfix">
                        @foreach($productAttributes as $name=>$value)
                            @if($value)
                                <li><p>{{$name}} :</p> <span>{{$value}}</span></li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="pro_more">
                        <div class="main-more"><a href="#content" class="inquiry_pro"><i class="fa fa-commenting"></i>Inquire Now</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="n_main">
    <script>
        $(window).scroll(function(){
            if($(this).scrollTop()>1600){
                $(".inquiry_pro").addClass("show")
            }else{
                $(".inquiry_pro").removeClass("show")
            }
        })
        (function () {
            // COUNTER
            $(document).scroll(function () {
                $('.odometer').each(function () {
                    var parent_section_postion = $(this).closest('.num_section').position();
                    var parent_section_top = parent_section_postion.top;
                    if ($(document).scrollTop() > parent_section_top - 800) {
                        if ($(this).data('status') == 'yes') {
                            $(this).html($(this).data('count'));
                            $(this).data('status', 'no');
                        }
                    }
                });
            });

        })(jQuery);
    </script>
    <div class="container">
        <div id="main" class="n_left">
            <div >
                <div class="modules">
                    <section class="block left_nav">
                        <div class="unfold nav_h4">Product categories</div>
                        <div class="toggle_content clearfix">
                            <ul class="mtree">
                                @foreach($productCategories as $productCategory)
                                    <li><span></span><a href="javascript:;">{{ $productCategory->name }}</a>
                                    @isset($productCategory->children[0])
                                        <ul>
                                            @foreach($productCategory->children as $children)
                                                <li><span></span><a href="javascript:;">{{ $children->name }}</a>
                                                    @isset($children->children[0])
                                                        <ul>
                                                            @foreach($children->children as $child)
                                                                <li><a href="javascript:;">{{ $child->name }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    @endisset
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endisset
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <script type="text/javascript" src="/pre/js/mtree.js"></script>
                    </section>
                    <section class="hot_left hidden_mob">
                        <div class="left_h4">New Products</div>
                        <div class="clearfix">
                            @inject('imagePresenter','App\Presenters\ShowThumbImagePresenter')
                            <ul>
                                @foreach($newProducts as $newProduct)
                                    <li>
                                        <div class="li clearfix">
                                            <a class="img" href="/preProduct/{{ $newProduct->id }}"><img src="{{ asset($imagePresenter->showImage($newProduct->productMainImage->path, 250)) }}" alt=""></a>
                                            <div class="h4"><a href="/preProduct/{{ $newProduct->id }}">{{ $newProduct->name }}</a></div>
                                            <a href="/preProduct/{{ $newProduct->id }}" class="more">read More<i class="fa fa-caret-right"></i></a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class=" n_right">
            <div class="products_main">
                <div class="features-tab indicator-style clearfix">
                    <ul class="nav nav-tabs moz clearfix" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#about01" aria-controls="home" role="tab" data-toggle="tab">Product Details</a>
                        </li>
                    </ul>
                    <div class="tab-content page">
                        <div role="tabpanel" class="tab-pane active" id="about01">
                            <p>
                                {!! $product->content !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tags_ul"><span> Hot Tags : </span>
                    @foreach($product->productTags as $tag)
                        <a href="javascript:;">{!! $tag->name !!}</a>
                    @endforeach
                </div>
                <div id="content"></div>
                <div class="pro_inq">
                    <div class="title">leave a message</div>
                    <div class="text">If you are interested in our products and want to know more details,please leave a message here,we will reply you as soon as we can.</div>
                    <div class="inquiry">
                        <form id="email_form" method="post" action="#" onsubmit="return false">
                            <ul class="row clearfix">
                                <li class="col-xs-12">
                                    <div class="subject_title">Subject : <a href="/products-06_p6.html">{{ $product->name }}</a></div>
                                </li>
                                <li class=" col-sm-6 col-xs-12">
                                    <span class="ms_e"><input type="text" name="msg_email" id="msg_email" class="meInput" placeholder="* Your Email"></span>
                                </li>
                                <li class=" col-sm-6 col-xs-12">
                                    <span class="ms_p"><input type="text" name="msg_phone" id="msg_phone" class="meInput" placeholder="Tel/Whatsapp"></span>
                                </li>
                                <li class="meText col-xs-12">
                                    <span class="ms_m"><textarea id="meText" placeholder="* Enter product details (such as color, size, materials etc.) and other specific requirements to receive an accurate quote." maxlength="3000" name="msg_content"></textarea></span>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                            <span class="ms_btn">submit</span>
                        </form>
                    </div>
                </div>
{{--                <ul class="navigation clearfix">--}}
{{--                    <li class="prev_post">--}}
{{--                        <a href="">--}}
{{--                            <span class="meta_nav">Previous Post</span>--}}
{{--                            <div class="post_title">We must work,and above all we must believe in ourselves.</div>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="next_post">--}}
{{--                        <a href="">--}}
{{--                            <span class="meta_nav">Next Post</span>--}}
{{--                            <div class="post_title">We must work,and above all we must believe in ourselves.</div>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
            </div>
        </div>
    </div>
</div>
<div class="pro_section">
    <div class="container">
        <div class="i_title">
            <div class="h4">Related Products</div>
            <p>Our PM components offer excellent optical performance, e.g., high extinction ratio and low insertion loss, as well as high reliability and have become the key enablers</p>
        </div>
        <div class="button_outside">
            <div class="swiper-container pro_scrollbar">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="li">
                            <a href="#" class="img"><img src="/pre/images/pro_img1.jpg" alt="" /><span class="icon"></span></a>
                            <div class="text">
                                <a href="#" class="h4">linewidth fiber laser</a>
                                <p>FIBERTOP SFP/SPC-BL45TG-80Dx 1490T/1550R 80km</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="li">
                            <a href="#" class="img"><img src="/pre/images/pro_img1.jpg" alt="" /><span class="icon"></span></a>
                            <div class="text">
                                <a href="#" class="h4">linewidth fiber laser</a>
                                <p>FIBERTOP SFP/SPC-BL45TG-80Dx 1490T/1550R 80km</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="li">
                            <a href="#" class="img"><img src="/pre/images/pro_img1.jpg" alt="" /><span class="icon"></span></a>
                            <div class="text">
                                <a href="#" class="h4">linewidth fiber laser</a>
                                <p>FIBERTOP SFP/SPC-BL45TG-80Dx 1490T/1550R 80km</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="li">
                            <a href="#" class="img"><img src="/pre/images/pro_img1.jpg" alt="" /><span class="icon"></span></a>
                            <div class="text">
                                <a href="#" class="h4">linewidth fiber laser</a>
                                <p>FIBERTOP SFP/SPC-BL45TG-80Dx 1490T/1550R 80km</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="li">
                            <a href="#" class="img"><img src="/pre/images/pro_img1.jpg" alt="" /><span class="icon"></span></a>
                            <div class="text">
                                <a href="#" class="h4">linewidth fiber laser</a>
                                <p>FIBERTOP SFP/SPC-BL45TG-80Dx 1490T/1550R 80km</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>
<!--footer-->
<div id="footer" style="background:#02224a">
    <div class="container">
        <div class="footer_about">
            <a href="#" class="footer_logo"><img src="/pre/images/footer_logo.png" alt=""/></a>
            <div class="p">Jinhua Noke Biotechnology Co., Ltd has its headquarters in Jinhua, Zhejiang, near Shanghai. As one of the leading manufacturers of high quality Laboratory glassware, biological consumables, equipments and some medical consumables, all NOKE LAB products are designed and manufactured in accordance with ISO9001/13485. We are positioned to be an one-stop supplier of a wide range of general laboratory consumables & instruments, covering chemical, biological, and clinical diagnostic labs.</div>
            <div class="footer_sns">
                <a href="#"><img src="/pre/images/sns_f.png" alt=""/></a>
                <a href="#"><img src="/pre/images/sns_in.png" alt=""/></a>
                <a href="#"><img src="/pre/images/sns_ins.png" alt=""/></a>
                <a href="#"><img src="/pre/images/sns_p.png" alt=""/></a>
                <a href="#"><img src="/pre/images/sns_t.png" alt=""/></a>
            </div>
        </div>
        <div class="ul footer_follow hidden_mob">
            <div class="title_h4">Follow Us</div>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">News</a></li>
                <li><a href="#">Sitemap</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>
        <div class="ul footer_tags hidden_mob">
            <div class="title_h4">Hot Tags</div>
            <ul>
                <li><a href="#">Bath & Shower Grab Bars</a></li>
                <li><a href="#">Mop Broom Holder</a></li>
                <li><a href="#">Soap Holder</a></li>
                <li><a href="#">Toothbrush Holder</a></li>
                <li><a href="#">Over Door Hooks</a></li>
                <li><a href="#">Hair Dryer Holder</a></li>
                <li><a href="#">Toilet Brushes & Holders</a></li>
            </ul>
        </div>
        <div class="footer_pro">
            <div class="swiper-news">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                        <a href="#" class="img"><img src="/pre/images/pro_img1.jpg" alt=""/></a>
                        <a href="#" class="title">Hollywood Vanity Mirror With Lights And Table</a>
                    </li>


                </ul>
                <div class="swiper-pagination"></div>
            </div>
            <script>
                var swiper = new Swiper('.swiper-news', {
                    effect: 'flip',
                    loop: true,
                    speed: 1000,
                    autoplay:true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            </script>
        </div>
    </div>
    <div class="clear"></div>
    <div class="footer_bottom">
        <div class="mob_follow hidden_web"><a href="#">Sitemap</a><a href="#">Blog</a><a href="#">News</a></div>
        <div class="cop">©Jinhua NOKE BIOTECHNOLOGY Co., Ltd. All Rights Reserved. <a href="#">XML</a>|<a href="#">Privacy Policy</a>  </div>
        <div class="ipv6"><img src="/pre/images/ipv6.png" alt="">IPv6 network supported</div>
        <div class="link">Links : <a href="#">google</a></div>
    </div>
</div>

<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewbox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
    </svg>
</div>
<div id="whatsapp">
    <div id="whatsapp_tab">
        <a id="floatShow2" rel="nofollow" href="javascript:void(0);" >
            <div class="online_icon">
                <span class="online_close"><svg><use xlink:href="#fixed-email-close"></use></svg></span>
                <span class="online_open"><svg><use xlink:href="#fixed-email-open"></use></svg></span>
                <span class="online_mobile"><svg><use xlink:href="#con-mes"></use></svg></span>
            </div>
            <p>Need Help? leave a message</p></a>
        <a id="floatHide2" rel="nofollow" href="javascript:void(0);" ></a>
    </div>
    <div id="onlineService2">
        <div class="title">
            <svg><use xlink:href="#icon-im"></use></svg>
            <div>
                <div class="h4">leave a message</div>
            </div>
        </div>
        <div class="inquiry">
            <div class="p">If you are interested in our products and want to know more details,please leave a message here,we will reply you as soon as we can.</div>
            <form id="email_form" method="post" action="/inquiry/addinquiry">
                <ul class="row clearfix">
                    <li class=" col-sm-12 col-xs-12">
                        <span class="ms_e"><input type="text" name="msg_email" id="msg_email" class="meInput" placeholder="* Your Email"></span>
                    </li>
                    <li class=" col-sm-12 col-xs-12">
                        <span class="ms_p"><input type="text" name="msg_phone" id="msg_phone" class="meInput" placeholder="Tel/Whatsapp"></span>
                    </li>
                    <li class="meText col-xs-12">
                        <span class="ms_m"><textarea id="meText" placeholder="* Enter product details (such as color, size, materials etc.) and other specific requirements to receive an accurate quote." maxlength="3000" name="msg_content"></textarea></span>
                    </li>
                    <div class="clearfix"></div>
                </ul>
                <span class="ms_btn"><input type="submit" value="">Submit</span>
            </form>
        </div>
    </div>
</div>
<!--service-->
<div class="fixed-contact">
    <ul class="item-list clearfix">
        <li>
            <div class="column">
                <svg class="icon"><use xlink:href="#con-tel"></use></svg>
                <a rel="nofollow" target="_blank" href="#">+86-595-88168193</a>
            </div>
        </li>
        <li>
            <div class="column">
                <svg class="icon"><use xlink:href="#con-email"></use></svg>
                <a rel="nofollow" target="_blank" href="#">info@beisite.com</a>
            </div>
        </li>
        <li>
            <div class="column">
                <svg class="icon"><use xlink:href="#con-whatsapp"></use></svg>
                <a rel="nofollow" target="_blank" href="#">+86-595-88168193</a>
            </div>
        </li>
        <li>
            <div class="column">
                <svg class="icon"><use xlink:href="#con-skype"></use></svg>
                <a rel="nofollow" target="_blank" href="#">beisite</a>
            </div>
        </li>
        <li class="online_code">
            <div class="column">
                <svg class="icon"><use xlink:href="#con-code"></use></svg>
                <a>
                    <p>Scan to wechat :</p><img src="/pre/images/right-wx.png" alt="" />
                </a>
            </div>
        </li>
    </ul>
</div>

<div class="mobile_nav clearfix">
    <a href="#"><svg class="icon"><use xlink:href="#icon-home"></use></svg><p>home</p></a>
    <a href="#"><svg class="icon"><use xlink:href="#icon-product"></use></svg><p>products</p></a>
    <a href="#"><svg class="icon"><use xlink:href="#icon-whatsapp"></use></svg><p>whatsApp</p></a>
    <a href="#"><svg class="icon"><use xlink:href="#con-mes"></use></svg><p>contact</p></a>
</div>

<script type="text/javascript" src="/pre/js/main.js"></script>
<script type="text/javascript" src="/pre/js/demo.js"></script>

</body>
</html>
