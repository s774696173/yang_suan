<?php

// 取名列表页 banner
function banner_quminglist_1(){
   echo '<div style="text-align:center;"><img src="/Public/images/ver2/bg-1.jpg" alt=""></div>';
}

// 单字名或双字名 
function name_is_single($order_num, $data_single_req){
    $name_is_single = ($data_single_req==1)?1:0;
    $name_single_str = '单字名';
    if($name_is_single == 0){
        $name_single_str = '双字名';
    }
    echo '<section class="name-regenerate">'.
        '<div class="form-content">'.
            '<div class="form-group form-group">'.
                '<div class="group-item surname-length">'.
                    '<span class="surname-length-value">'.$name_single_str.'</span>'.
                    '<div class="surname-options">'.
                        '<a href="javascript:void(0)">单字名</a>'.
                        '<a href="javascript:void(0)">双字名</a>'.
                    '</div>'.
                '</div>'.
            '</div>'.
            '<div class="form-group">'.
                    '<a href="quminglist.php?order_num='.$order_num.'&single='.$name_is_single.'" class="btn btn-block btn-get-name namesReget">重新生成</a>'.
            '</div>'.
            '<hr>'.
        '</div>'.
    '</section>';
}

// 姓名列表
function name_list_html($data_xing, $data_gender, $shengxiao, $order_num, $data_name_list){
    $title_names_html = '';
    $name_list_html = '';
    foreach(mb_str_split($data_xing) as $the_name_key=>$the_name_value){
            $title_names_html.='<span><i>'.$the_name_value.'</i><em></em></span>';
        }
        $title_names_html.='<span><i>姓</i><em></em></span><span><i>'.$data_gender.'</i><em></em></span><span><i>孩</i><em></em></span><span><i>姓</i><em></em></span><span><i>名</i><em></em></span><span><i>大</i><em></em></span><span><i>全</i><em></em></span>';
    foreach( $data_name_list as $name){
        $firstname = $name['name'];
        $name_score = $name['score'];
        $name_details_url = 'name_details.php?firstname='.$firstname.'&lastname='.$data_xing.'&shengxiao='.$shengxiao.'&score='.$name_score.'&order_num='.$order_num;
        $name_list_html.='<li class="list-item"><a href="'.$name_details_url.'">'.$data_xing.$firstname.'</a></li>';
    }
    echo '<article class="block-item">'.
            '<h4 class="g-title-primary">'.
                '<span>取名效果展示</span>'.
                '<div class="g-pattern type-1"></div>'.
            '</h4>'.
            '<header class="title-name-result">'.$title_names_html.'</header>'.
            '<section class="g-block-white">'.
                '<div class="name-list loadmore">'.
                    '<ul class="list-itmes hidden">'.$name_list_html.'</ul>'.
                    '<ul class="list-itmes list">数据加载中，请稍后...</ul>'.
                    '<div class="name-result-more">'.
                        '<a href="javascript:void(0)" class="add_more">更多'.
                            '<i class="icon icon-get-more"></i>'.
                        '</a>'.
                    '</div>'.
                    '<p class="text-center"><span class="add_dashi_weixin"></span></p><br>'.
                '</div>'.
            '</section>'.
        '</article>'.
        '<hr>';
}

// 性别，姓氏，阳历日期，农历日期
function name_info_basic($data_gender, $data_xing, $data_birthtimeStr ,$data_birthtimeStr_nongli){
    echo '<article class="block-item">
            <h4 class="g-title-primary">
                <span>基本信息</span>
                <div class="g-pattern type-1"></div>
            </h4>
            <section class="g-block-white">
                <div class="basic">
                    <div class="item title">
                        <div class="text-center">
                            <p>性别</p>
                        </div>
                        <div class="text-center">
                            <p>姓氏</p>
                        </div>
                        <div class="text-center">
                            <p>出生日期</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="text-center">
                            <p>'.$data_gender.'</p>
                        </div>
                        <div class="text-center">
                            <p>'.$data_xing.'</p>
                        </div>
                        <div class="text-left">
                            <p>
                                <span class="text-primary-red">阳历：</span>'.$data_birthtimeStr.'
                            </p>
                            <p>
                                <span class="text-primary-red">农历：</span>'.$data_birthtimeStr_nongli.'
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <hr>';
}

// 生肖信息
function name_info_shengxiao($shengxiao){
    echo '<article class="block-item">
            <h4 class="g-title-primary">
                <span>生肖</span>
                <div class="g-pattern type-1"></div>
            </h4>
            <section class="g-block-white">
                <div class="zodiac zodiac-'.get_shengxiao_num($shengxiao).'">
                    <i class="g-pattern-zodiac pattern-left"></i>
                    <i class="g-pattern-zodiac pattern-right"></i>
                    <div class="title text-center">
                        <p>月历生肖：
                            <span class="text-primary-red">'.$shengxiao.'</span>
                        </p>
                        <p>阳历生肖：
                            <span class="text-primary-red">'.$shengxiao.'</span>
                        </p>
                        <p>阴历生肖：
                            <span class="text-primary-red">'.$shengxiao.'</span>
                        </p>
                    </div>
                    <p class="details">
                        月历生肖为按照立春划分的年份生肖，阳历生肖为 每年12月31日划分，阴历生肖为每年春节划分，推 算生辰八字依照月历生肖，每个人的真实生肖即为 月历生肖。
                    </p>
                </div>
            </section>
        </article>
        <hr>';
}

// 节气开始时间年月日，小时； 节气截止时间 年月日，小时
function name_info_jieqi($jieqi){

    $jieqi_from = $jieqi[0];
    $jieqi_to = $jieqi[1];
    
    $jieqi_from_name = $jieqi_from['name'];
    $jieqi_from_date = $jieqi_from['current_date'];
    $jieqi_from_month_lunar = $jieqi_from['lunar_month_name'];
    $jieqi_from_day_lunar = $jieqi_from['lunar_day_name'];
    $jieqi_from_hour = $jieqi_from['time'];
    
    $jieqi_to_name = $jieqi_to['name'];
    $jieqi_to_date = $jieqi_to['current_date'];
    $jieqi_to_month_lunar = $jieqi_to['lunar_month_name'];
    $jieqi_to_day_lunar = $jieqi_to['lunar_day_name'];
    $jieqi_to_hour = $jieqi_from['time'];

    $date_jieqi_from = $jieqi_from_date.' '.$jieqi_from_hour;
    $date_jieqi_to = $jieqi_to_date.' '.$jieqi_to_hour;

    $date_jieqi_to_str = str_format_time($date_jieqi_to);
    $date_jieqi_from_str = str_format_time($date_jieqi_from);
    echo '<article class="block-item">
            <h4 class="g-title-primary">
                <span>节气</span>
                <div class="g-pattern type-1"></div>
            </h4>
            <section class="g-block-white">
                <div class="solar-terms ">
                    <div class="title">
                        <div class="solar-term-'.get_jieqi_num($jieqi_from_name).'">
                            <span class="title-pic from"></span>
                           
                        </div>
                        <div>
                            <div class="title-info">
                                <span>生于'.$jieqi_from_name.'和</span>
                                <span>'.$jieqi_to_name.'之间</span>
                            </div>
                        </div>
                        <div class="solar-term-'.get_jieqi_num($jieqi_to_name).'">
                            <span class="title-pic to"></span>
                            
                        </div>
                    </div>
                    <div class="text">
                        <div>
                            <p>'.date("Y", $date_jieqi_from_str).'年'.date("m", $date_jieqi_from_str).'月'.date("d", $date_jieqi_from_str).'日'.date("H", $date_jieqi_from_str).'时'.date("i", $date_jieqi_from_str).'分'.'</p>
                        </div>
                        <div>
                            <p>'.date("Y", $date_jieqi_to_str).'年'.date("m", $date_jieqi_to_str).'月'.date("d", $date_jieqi_to_str).'日'.date("H", $date_jieqi_to_str).'时'.date("i", $date_jieqi_to_str).'分'.'</p>
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <hr>';
}

// 八字五行占比
function name_info_wuxing_percent($wuxing_percentage){
    $index  = 0;
    $wuxin_html = '';
    $wuxing_percentage_sum = get_wuxing_sum($wuxing_percentage);
    foreach( $wuxing_percentage as $wx_key => $wx_val):
        $percent = round( $wx_val/$wuxing_percentage_sum * 100 , 2) . "%";
        $index ++;
        $wuxin_html.='<ul>'.
            '<li class="list-pic"><img src="/Public/images/ver2/wuxing-'.$index.'-1.png" alt=""></li>'.
            '<li><span><i style="width:'.$percent.';"><img src="/Public/images/ver2/wuxing-'.$index.'.png" alt=""></i></span></li>'.
            '<li>'.$percent.'</li>'.
        '</ul>';
    endforeach;
    echo '<article class="block-item">'.
                '<h4 class="g-title-primary">'.'<span>五行旺弱</span><div class="g-pattern type-1"></div></h4>'.
                '<section class="g-block-white">'.
                '<div class="wuxing">'. $wuxin_html.'<p class="text-primary-red">五行并非缺什么就补什么，应该先天八字中五行同 类和异类平衡为原则，补充最需要的五行作为喜用 神。</p>'.
            '</div>'.
        '</section>'.
    '</article>'.
    '<hr>';
}

// 八字喜用神分析
function name_info_bazi_notice(){
    echo '<article class="block-item">
            <h4 class="g-title-primary">
                <span>八字喜用神分析</span>
                <div class="g-pattern type-1"></div>
            </h4>
            <section class="g-block-white">
                <div class="bazi-details">
                    <p>
                        <span>金：</span>在方位上代表西方，在季节方面代表秋季，颜 色代表白色，身体器官表示肺，情感方面表示悲， 天干方面表示庚辛，地支方面表示申酉，八卦方面 表示兑乾。
                    </p>
                    <p>
                        <span>木：</span>在方位上代表东方，在季节方面代表春季，颜 色代表青色，身体器官表示肝，情感方面表示怒， 天干方面表示甲乙，地支方面表示寅卯，八卦方面 表示震巽。
                    </p>
                    <img src="/Public/images/ver2/bazi-details.png" alt="">
                    <p>
                        <span>水：</span>在方位上代表北方，在季节方面代表冬季，颜 色代表黑色，身体器官表示肾，情感方面表示惊， 天干方面表示壬癸，地支方面表示亥子，八卦方面 表示坎。
                    </p>
                    <p>
                        <span>火：</span>在方位上代表南方，在季节方面代表夏季，颜 色代表红色，身体器官表示心，情感方面表示喜， 天干方面表示丙丁，地支方面表示巳午，八卦方面 表示离。
                    </p>
                    <p>
                        <span>土：</span>在方位上代表中央，在季节方面代表每季末月 ，颜色代表黄色，身体器官表示脾，情感方面表示 思，天干方面表示戊己，地支方面表示辰戌丑未， 八卦方面表示坤艮。
                    </p>
                </div>
            </section>
        </article>';
}

// 生肖姓名学
function name_info_shengxiao_intro(){
    echo '<h4 class="g-title-primary-2">
            <span>生肖姓名学</span>
        </h4>
        <div class="name-zodiac">
            <p>
                古人认为一个人的名字和十二生肖有直接关联，古 人根据对生肖动物的象形、指示、会意、形声、转注、 假借，再结合生肖与天干、地支、五行的关系总结出 生肖姓名学。<span class="add_dashi_weixin"></span>
            </p>
        </div>';
}

// 生肖喜用禁忌
function name_info_shengxiao_notice($shengxiao){
        $shengxiao_pic_html ='';
        $shengxiao_current = get_shengxiao_num($shengxiao);
        for($i = 1; $i<13;$i++){
            $current = '';
            ($i == 10)? $current ='current' : $current ='' ;
            $shengxiao_pic_html.='<span class="'.$current.'"><i><img src="/Public/images/ver2/pic-zodiac-'.$i.'.png" alt=""></i></span>';
        }
    echo '<article class="block-item">
        <h4 class="g-title-primary">
            <span>生肖禁忌举例</span>
            <div class="g-pattern type-1"></div>
        </h4>
        <div class="zodiac-detaisl-pics">
            <div>'.$shengxiao_pic_html.'</div>
        </div>
        <div class="zodiac-detaisl-text">
            <img src="/Public/images/ver2/pic-zodiac-10.png" alt="">
            <ul>
                <li>
                    <h3>喜用</h3>

                </li>
                <li>
                    <h3>避免</h3>

                </li>
            </ul>
            <ul>
                <li>
                    <p>(1)宜有“禾”、“豆”、“米”、“梁”、“麦”、“栗”之字根，因鸡为食五谷杂粮的动物，整天都在找粮食，见到杂粮，欢欣鼓舞，可以吃撑到脖子，有以上字根，属鸡之人，内心充实饱满。</p>
                </li>
                <li>
                    <p>(1) 属鸡之人最怕见到与其对冲之字形，因鸡为酉，卯与酉对冲，所以凡是有“卯”之字形或字义均不可犯之。如犯之，则伤害大，刑伤、生病难免，卯之字义可推及东方之月、兔均属之，因卯居东方，酉局西方，东酉对冲，所以有“东”、“月”、“兔”之字形不可用。“兔”之字形不可用。</p>
                </li>
            </ul>
            <ul>
                <li>
                    <p>(2)属鸡之人喜用有“山” 之字形，为鸡上山头，可 展其英姿，有凤凰之象， 提升其格局地位。另外， 鸡本来都喜欢栖息在树干 上睡觉、打盹，安详自在。</p>
                </li>
                <li>
                    <p>(2)属鸡之人不喜见到“金” 之字形，因鸡为酉金，但 五行中，金与金组合过重， 容易犯冲金属杀伐之意， “金”之字意还有“西”、 “兑”、“申”、“秋”、 “酉”均属之。</p>
                </li>
            </ul>
            <ul>
                <li>
                    <p>(3)属鸡之人喜见用“彡”、“纟”、“采”、“系”之字形，“彡”字形为鸡的羽毛漂亮，即增加其人缘，“采”的字形，即代表鸡冠漂亮，冠冕加身之意，雄赳赳、气昂昂。</p>
                </li>
                <li>
                    <p>(3)其他：属鸡之人亦不喜见有“刀”、“示”、“力”、“石”、“人”、“手”、“血”、“水”、“字”、“子、“亥”、“北”之字形。</p>
                </li>
            </ul>
        </div>
        <p class="text-center" style="margin: .3rem auto;"><span class="add_dashi_weixin"></span></p>
        </article>';
}

// 八字详批
function name_info_bazi_details($data_gender, $data_bazi){
    ($data_gender =='男') ? $gender_zao= '乾造': $gender_zao = '坤造';
    $wxEraYear_html='';
    $wxEraMonth_html='';
    $wxEraDay_html='';
    $wxEraHour_html='';
    $cgYear_html='';
    $cgMonth_html='';
    $cgDay_html='';
    $cgHour_html='';
    $cgYearWx_html='';
    $cgMonthWx_html='';
    $cgDayWx_html='';
    $cgHourWx_html = '';
    foreach( $data_bazi['wxEraYear'] as $wxEraYear){
        $wxEraYear_html.=$wxEraYear;
    }
    foreach( $data_bazi['wxEraMonth'] as $wxEraMonth){
        $wxEraMonth_html.=$wxEraMonth;
    }
    
    foreach( $data_bazi['wxEraDay'] as $wxEraDay){
        $wxEraDay_html.= $wxEraDay;
    }
                                
    foreach( $data_bazi['wxEraHour'] as $wxEraHour){
        $wxEraHour_html.=$wxEraHour;
    }
    
    foreach( $data_bazi['cgYear'] as $cgYear){
        $cgYear_html.=$cgYear;
    }
    
    foreach( $data_bazi['cgMonth'] as $cgMonth){
        $cgMonth_html.=$cgMonth;
    }
    
    foreach( $data_bazi['cgDay'] as $cgDay){
        $cgDay_html.=$cgDay;
    }
    
    foreach( $data_bazi['cgHour'] as $cgHour){
        $cgHour_html.=$cgHour;
    }
    
    foreach( $data_bazi['cgYearWx'] as $cgYearWx){
        $cgYearWx_html.=$cgYearWx;
    }
    foreach( $data_bazi['cgMonthWx'] as $cgMonthWx){
        $cgMonthWx_html.=$cgMonthWx;
    }
    
    foreach( $data_bazi['cgDayWx'] as $cgDayWx){
        $cgDayWx_html.=$cgDayWx;
    }
    
    foreach( $data_bazi['cgHourWx'] as $cgHourWx){
        $cgHourWx_html.=$cgHourWx;
    }
    

    echo '<article class="block-item">
            <h4 class="g-title-primary">
                <span>八字详批</span>
                <div class="g-pattern type-1"></div>
            </h4>
            <section class="bazi">
                <ul>
                    <li>&nbsp</li>
                    <li>年柱</li>
                    <li>月柱</li>
                    <li>日柱</li>
                    <li>时柱</li>
                </ul>
                <ul>
                    <li>十神</li>
                    <li>'.$data_bazi['ssEraYear'].'</li>
                    <li>'.$data_bazi['ssEraMonth'].'</li>
                    <li>'.$data_bazi['ssEraDay'].'</li>
                    <li>'.$data_bazi['ssEraHour'].'</li>
                </ul>
                <ul>
                    <li>'.$gender_zao.'</li>
                    <li>'.$data_bazi['cnEraYear'].'</li>
                    <li>'.$data_bazi['cnEraMonth'].'</li>
                    <li>'.$data_bazi['cnEraDay'].'</li>
                    <li>'.$data_bazi['cnEraHour'].'</li>
                </ul>
                <ul>
                    <li>'.$gender_zao.'五行</li>
                    <li>'.$wxEraYear_html.'</li>
                    <li>'.$wxEraMonth_html.'</li>
                    <li>'.$wxEraDay_html.'</li>
                    <li>'.$wxEraHour_html.'</li>
                </ul>
                <ul>
                    <li>臧干</li>
                    <li>'.$cgYear_html.'</li>
                    <li>'.$cgMonth_html.'</li>
                    <li>'.$cgDay_html.'</li>
                    <li>'.$cgHour_html.'</li>
                </ul>
                <ul>
                    <li>臧干五行</li>
                    <li>'.$cgYearWx_html.'</li>
                    <li>'.$cgMonthWx_html.'</li>
                    <li>'.$cgDayWx_html.'</li>
                    <li>'.$cgHourWx_html.'</li>
                </ul>
                <ul>
                    <li>纳音</li>
                    <li>'.$data_bazi['nyYear'].'</li>
                    <li>'.$data_bazi['nyMonth'].'</li>
                    <li>'.$data_bazi['nyDay'].'</li>
                    <li>'.$data_bazi['nyHour'].'</li>
                </ul>
                <ul>
                    <li>命里</li>
                    <li>'.$data_bazi['mingju'].'</li>
                </ul>
            </section>
        </article>
        <hr>';
}

// 八字性格分析
function name_info_bazi_xingge($data_sancai){
    echo '<h4 class="g-title-primary-2">
            <span>八字性格分析</span>
        </h4>
        <div class="name-bazi">
            <p>'.$data_sancai['sancai_info']['性格'].'</p>
        </div>';
}

// 运势详解
function name_info_lucky($data_sancai){
    $name_lucky_html='';
    $i = 0;
    foreach($data_sancai['sancai_info'] as $key=>$val){
        if($key == 'id' || $key == '三才' || $key == '老运' || $key == '子女' || $key == '性格' ){
            continue;
        }
        $i ++;
        $title_bg_color = $i%9;
        $name_lucky_html.='<div><h4 class="bg-primary-'.$title_bg_color.'"><span>'.$key.'：</span></h4>';
        $name_lucky_html.='<p>'.$val.'</p></div>';
    }
    echo '<h4 class="g-title-primary-2">
            <span>运势详解</span>
        </h4>
        <div class="name-lucky">'.$name_lucky_html.'<div></div></div>';
}

// 名字解析结果
function name_info_result($data_gender, $shengxiao, $data_birthtimeStr, $data_birthtimeNongliStr){
    echo '<h4 class="g-title-primary-2">
                <span>基本信息</span>
            </h4>
            <div class="name-details-info">
                <ul>
                    <li>
                        <span>性别</span>
                    </li>
                    <li>
                        <span>'.$data_gender.'</span>
                    </li>
                </ul>
                <ul>
                    <li>
                        <span>生肖</span>
                    </li>
                    <li>
                        <span>'.$shengxiao.'</span>
                    </li>
                </ul>
                <ul>
                    <li>
                        <span>公历生日</span>
                    </li>
                    <li>
                        <span>'.$data_birthtimeStr.'</span>
                    </li>
                </ul>
                <ul>
                    <li>
                        <span>农历生日</span>
                    </li>
                    <li>
                        <span>'.$data_birthtimeNongliStr.'</span>
                    </li>
                </ul>
            </div>';
}

// 起名结果详细解释
function name_info_result_details($lastname, $firstname, $data_sancai){
    $the_name_html ='';
    $sancai_html = '';
    $data_sancai_html = '';
    $the_name = $lastname.$firstname;
    $name_sancai_array = mb_str_split($data_sancai['sancai']);
    foreach(mb_str_split($the_name) as $the_name_key=>$the_name_value){
        $the_name_html.= '<div><span class="name"><i></i><i></i><em>'.$the_name_value.'</em></span></div>';
        if($name_sancai_array[$the_name_key]) $sancai_html.= '<div><span>['.$name_sancai_array[$the_name_key].']</span></div>';
    }
    foreach( $data_sancai['names_info'] as $key=>$val){
        if($val){
            foreach( $val as $k => $v){
                if($k == '基本解释' || $k == '详细解释'){
                    $data_sancai_html.='<p>'.$k.'</p><p>'.$v.'</p>';
                }
            }
        }
    }

    echo '<h4 class="g-title-primary-2">
            <span>起名结果</span>
        </h4>
        <div class="name-explain">
            <div class="name-explain-title">'.$the_name_html.'</div>
            <div class="name-explain-title">'.$sancai_html.'</div>
            <div class="name-score">综合评价:  <span>'.$data_sancai['sancai_info']['吉凶'].'</span></div>'.$data_sancai_html.'
        </div>';
}

// 提示用户绑定手机号弹窗
function modal_bind_phone_num(){
    echo '<section class="modal modal-user-contact">
        <div class="modal-content">
            <div class="modal-msg msg-danger">请输入正确的手机号码</div>
            <a href="javascript:void(0)" class="btn btn-close">×</a>
            <div class="modal-body">
                <div class="modal-title">输入手机号永久保存结果</div>
                <input type="text" name="userPhoneNum" placeholder="请输入您的手机号" class="userPhoneNum">
                <button type="submit" class="btn-submit">确定</button>
            </div>
        </div>
    </section>';
}

// 底部添加大师微信
function add_weixin_html_bottom_fixed(){
    echo '<p class="item-addWeixin">
            <i class="icon-addWeixin"></i><span class="add_dashi_weixin"></span>
        </p>';
}

// 姓名列表页内容
function main_content_namelist($data){
    $shengxiao = $data['shengxiao'];
    $order_num = $data['order_num'];
    $single = $data['single'];
    $gender = $data['gender'];
    $lastname = $data['xing'];
    $namelist = $data['name_list'];
    $birthtimeStr = $data['birthtimeStr'];
    $birthtimeNongliStr = $data['birthtimeNongliStr'];
    $jieqi = $data['jieqi'];
    $wuxing_percentage = $data['wuxing_percentage'];
    $bazi = $data['bazi'];

    echo '<main class="main-content-namelist name-result">';

    // banner
    banner_quminglist_1();
    
    // 重新生成 单字名 或 双字名 
    name_is_single($order_num, $single);

    // 姓名列表展示
    name_list_html($lastname, $gender, $shengxiao, $order_num, $namelist);

    // 基本信息 根据
    name_info_basic($gender, $lastname, $birthtimeStr, $birthtimeNongliStr);

    // 生肖
    name_info_shengxiao($shengxiao);

    //节气
    name_info_jieqi($jieqi);
    
    // 五行占比
    name_info_wuxing_percent($wuxing_percentage);

    // 八字详批
    name_info_bazi_details($gender, $bazi);

    // 八字喜用神分析
    name_info_bazi_notice();

    // 生肖喜用禁忌
    name_info_shengxiao_notice($shengxiao);
    
    echo '</main>';

    // 加老师微信
    add_weixin_html_bottom_fixed();
}

// 姓名详情页
function main_content_name_details($data){

    $sancai = get_sancai_paid($data['firstname'], $data['lastname']);
    $shengxiao = $data['shengxiao'];+
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $gender = $data['gender'];
    $birthtimeStr = $data['birthtimeStr'];
    $birthtimeNongliStr = $data['birthtimeNongliStr'];

    echo '<main class="main-content-namelist name-details">
        <h4 class="g-title-primary">
            <span>名字解析结果</span>
            <div class="g-pattern type-1"></div>
        </h4>
        <section class="g-block-white name-details-content">';
            
    // 名字解析结果
    name_info_result($gender, $shengxiao, $birthtimeStr, $birthtimeNongliStr);

    // 起名结果详细解释
    name_info_result_details($lastname, $firstname, $sancai);

    // 生肖姓名学
    name_info_shengxiao_intro();
    
    // 生肖喜用禁忌
    name_info_shengxiao_notice($shengxiao);

    // 八字性格分析
    name_info_bazi_xingge($sancai);

    // 运势详解
    name_info_lucky($sancai);
    echo '</section><p class="text-center"><span class="add_dashi_weixin"></span></p></main>';

    // 绑定手机号弹窗
    modal_bind_phone_num();

    // 加老师微信
    add_weixin_html_bottom_fixed();
}

// 算命结果内容
function main_content_name_details_suan($data){
    echo '<main class="main-content-namelist main-content-namelist name-details name-result">';
    $fullname = $data['fullname'];
    $shengxiao = $data['shengxiao'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $gender = $data['gender'];
    $birthtimeStr = $data['birthtimeStr'];
    $birthtimeNongliStr = $data['birthtimeNongliStr'];
    $bazi = $data['bazi'];
    $jieqi = $data['jieqi'];
    $wuxing_percentage = $data['wuxing_percentage'];
    // 基本信息： 命主姓名，出生公历，出生农历，命主生肖 shengXiao，命主佛，命主星座 constellation，命挂分析 mingju
    echo '<section class="name-info-basic-suan">
        <div></div>
        <p><span>命主姓名</span><span>'.$fullname.'</span></p>
        <p><span>出生公历</span><span>'.$birthtimeStr.'</span></p>
        <p><span>出生农历</span><span>'.$bazi['mingju'].'</span></p>
        <p><span>命主星座</span><span>'.$birthtimeNongliStr.'</span></p>
        <p><span>命挂分析</span><span>'.$bazi['mingju'].'</span></p></section>';
    
    name_info_bazi_details($gender, $bazi);

    //节气
    name_info_jieqi($jieqi);
    
    // 五行占比
    name_info_wuxing_percent($wuxing_percentage);

    // 八字喜用神分析
    name_info_bazi_notice();

    // 生肖喜用禁忌
    name_info_shengxiao_notice($shengxiao);
    
    // 生肖姓名学
    name_info_shengxiao_intro();
    
    echo '</main>';

    // 绑定手机号弹窗
    modal_bind_phone_num();

    // 加老师微信
    add_weixin_html_bottom_fixed();
}