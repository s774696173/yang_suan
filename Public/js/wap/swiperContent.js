function getPhoneNumRandom(ordersLength) {
    var numArray = ["139", "138", "137", "136", "135", "134", "159", "158", "157", "150", "151", "152", "188", "187", "182", "183", "184", "178", "130", "131", "132", "156", "155", "186", "185", "176", "133", "153", "189", "180", "181", "177"];
    var arraryLength = numArray.length;
    var newPhoneNums = [];
    for (var o = 0; o < ordersLength; o++) {
        var phoneAhead = numArray[parseInt(Math.random() * arraryLength)];
        var randomCode = function (len, dict) {
            for (var i = 0, rs = ''; i < len; i++)
                rs += dict.charAt(Math.floor(Math.random() * 100000000) % dict.length);
            return rs;
        };
        var randomPhoneNumber = function () {
            // return [1, randomCode(2, '34587'), '****', randomCode(4, '0123456789')].join('');
            //return [phoneAhead, '****', randomCode(4, '0123456789')].join('');
            return ['****', randomCode(4, '0123456789')].join('');
        };
        newPhoneNums.push(randomPhoneNumber());
    }
    return newPhoneNums;
}
function getOrdersNumRandom(ordersLength) {
    var ordersRandom = function (n) {
        var num_str = "";
        for (var i = 0; i < n; i++) {
            var num = Math.floor(Math.random() * 10);
            num_str = num_str + num;
        }
        return num_str;
    }
    var myDate = new Date();
    var orders = [];
    for (var i = 0; i < ordersLength; i++) {
        var order_no = ordersRandom(5);
        var myDateStr = myDate.getFullYear().toString();
        orders.push(order_no);
    }
    return orders;
}
function setNewOrderListRandom(orderPrefix, orderPirce, ordersLength) {
    var list = '';
    var ordersArr = '';
    var swiperList = '';
    ordersArr = getPhoneNumRandom(ordersLength);
    for (var i = 0; i < ordersArr.length; i++) {
        list += '<div class="swiper-slide list-item">' + '<span class="order-name">周易起名网</span><span class="order-num">' + orderPrefix + ordersArr[i] + '</span><span class="order-price">￥<i class="price">' + orderPirce + '</i></span>' + '</div>';
    }
    $('.newOrdersList .list-items').html(list);
}

function setCommentListRandom(orderPrefix) {
    var orders = '';
    var list = '';
    var swiperList = '';
    var num = 0;
    commentListRandom = [
        '我加了大师买到的人工起名套餐，名字起的确实很专业，还有各种字义，音律，字形的详解，我问什么都能回答，太专业了，感谢麽麽哒～',
        '给宝宝起名现在不用愁了，这个网站很方便，还有大师帮忙，相当不错，哈哈',
        '名字非常有内涵有诗意，适合给娃起名用，不错，多谢大师指点迷津',
        '宝宝快出生了，原本还很烦恼宝宝取名的问题，后来朋友推荐我来这里找大师帮忙，很满意',
        '之前起的名字没一个顺的，不是不符合喜用神，就是罕有忌用字，所以就在这网站上起名，我看有各种各样的项目',
        '原本就是打算一家人查字典起名，但都很不理想。小时候吃够了名字的苦，这次请专业起名站给起的名字，确实非常大气。全家人尤其是爷爷奶奶辈（当年的大学生哦！）特别喜欢，都说给起的名字好！',
        '名字对于个人的影响还是比较大的，周围很多人的孩子名字都一个样。孩子奶奶想了20多个名字了，都是什么伟、强、雄之类的，最后还是得找专业起名老师，名字拿到后给这边老家人看了，说结合八字很好，确实可以给你留个评价吧。',
        '之前为了给孩子注册个户口，字典都快翻烂了。自问已经是读文学出身，但好名字还是要找专业的人来起，至少目前她爷爷那边就特别满意，说如鱼得水、如沐春风…',
        '名字真的非常好，完全超出我的意料之外，第一个名字不大满意（跟一个远亲的名字重叠），很快就重新给了另外一个名字，真的大气哦！',
        '名字一拿到手就觉得特别好，不知道怎么说，但是你一看到了就懂了。起名的时间有点儿长，期间催了2次特别不好意思啊，但是结果真的是好！',
        '前几天他阿姨给介绍来这里起名的，名字特别优美。不知道为啥起的名字连孩子都很喜欢，每次叫她名字就一直笑嘻嘻的，现在家人都很高兴。',
        '刚刚拿到的名字就来评价了，真的很不错，看得出来就是花了很多心思的。本来还有点疑惑，但是全部都能够一一解释，完全打消了我的顾虑。',
        '简直就是超出了所有的想象，本来是打算叫做X丽，但丽字家人不喜欢，说是比较容易重名。让这里的老师给起名了，特别好，高端大气上档次，过2年再生一个还来。',
        '很多人都推荐这里的老师起名，所以就跟来了，总的来说起名不脱俗套，专门指定跟八字结合的，都能一一满足，时间等的有点急，但是很值得。',
        '当时起好名字发给我，我没看到，就直接电话给我了。确实是很不错的，老师那边给解释的很清楚了，还发了文字资料给我，全都看明白了。',
        '以前的名字叫起来很拗口，这次是给自己改名的。新的名字已经去办更名了，朋友都说很不错，就是一开始不大适应，但是事业和朋友缘都很明显好了起来了，今天升职了所以来这里感谢老师。',
        '这里起名最大的优势是解析相当清楚，当时有点不明白八字啥意思，全部给我说了一次，通俗易懂，很感谢。差点就忘记给好评了，补上。',
        '嘿嘿嘿，宝宝的名字有了，叫做叶X伦，具体我就不说出来了哈哈。主要是涵义真的非常的好，完全结合了爸爸妈妈的优点，这样每次念出来都感动的想要落泪。',
        '怎么说呢？对于我们没有文化的人来说，起个叫做大牛、雄彪之类的已经是极限了。但老师给的名字既大气又不俗，真真的可以哈，让老妹以后也找老师起名了',
        '爷爷奶奶特别满意！孩子以后懂事的话，也一定会非常满意的，因为名字真的是很有意境，传统但不失典雅，以后肯定是个人才！'
    ];
    num = commentListRandom.length;
    orders = getOrdersNumRandom(num);
    for (var i = 0; i < num; i++) {
        list += '<li class="swiper-slide list-item">' + '<h5 class="order-num">' + orderPrefix + '***' + orders[i] + '</h5><p>' + commentListRandom[i] + '</p>' + '</li>';
    }
    $('.commentList .list-items').html(list);
}

jQuery(document).ready(function ($) {
    setNewOrderListRandom("20", "29.80", 100);
    setCommentListRandom("20");
});

function setCommonProblems() {
    var problemsText = [[
        '为什么要采用周易起名？',
        '易经作为传承千年的中国文化，暗合阴阳、八卦、五行、五格等万事万物。姓名是个人的符号，也在易经当中运行不息，反过来又影响人的前途和境况，健康和命运，因此采用周易起名不仅仅是传统，更是一个传承千年的必然。'
    ], [
        '八字缺什么补什么就好，为什么要找老师起名？',
        '首先八字并非缺什么补什么，名字不仅仅考虑八字，也考虑五行、命理影响，因此而需要结合易学经典的阴阳五行学说进行。起名网老师都拥有20年以上起名经验，对周易和五行、八字有深刻的领悟和理解，起名结合周易五行，通晓八字命格，能够最大限度化解八字不合，命格不顺的问题。'
    ], [
        '老师发过来的名字都可以使用吗？',
        '是的，一般老师肯定会推荐一个最佳选择。如果对推荐的名字不满意，例如跟亲人重名，也可以从备选的名单中选择。…'
    ], [
        '为什么要采用周易起名？',
        '易经作为传承千年的中国文化，暗合阴阳、八卦、五行、五格等万事万物。姓名是个人的符号，也在易经当中运行不息，反过来又影响人的前途和境况，健康和命运，因此采用周易起名不仅仅是传统，更是一个传承千年的必然。'
    ], [
        '八字缺什么补什么就好，为什么要找老师起名？',
        '首先八字并非缺什么补什么，名字不仅仅考虑八字，也考虑五行、命理影响，因此而需要结合易学经典的阴阳五行学说进行。起名网老师都拥有20年以上起名经验，对周易和五行、八字有深刻的领悟和理解，起名结合周易五行，通晓八字命格，能够最大限度化解八字不合，命格不顺的问题。',
    ], [
        '老师发过来的名字都可以使用吗？',
        '是的，一般老师肯定会推荐一个最佳选择。如果对推荐的名字不满意，例如跟亲人重名，也可以从备选的名单中选择。',
    ], [
        '付款后大概什么时候可以拿到结果？',
        '起名需要一定的周易演算和命理格局推敲，一般我们会尽量在一个小时以内完成。如果超过了预定时间，还没有收到的话，请直接联系在线老师。',
    ], [
        '要是对名字不满意，怎么办？',
        '一般老师都会推荐一组名字给到你，这样可以从数个名字当中挑选最适合的名字。如果还是对名字不满意的话，建议直接联系老师说明情况，可以重新起名。需要注意的是，名字一定不要只谈好不好听，而还要注重是否符合周易、五行等起名原理。',
    ]];
    // for(var i=0; i<problemsText.length;i++ ){
    //     console.log(problemsText[i])
    // }
}

function commentsOutput() {
    function shuffle(arr) {
        var i, j, temp;
        for (i = arr.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            temp = arr[i];
            arr[i] = arr[j];
            arr[j] = temp;
        }
        return arr;
    };
    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "h+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 -
            RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length ==
                1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

    function timeConverter(UNIX_timestamp) {
        var a = new Date(UNIX_timestamp * 1000);
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
            'Dec'
        ];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = hour + ':' + (min < 10 ? "0" + min : min);
        return time;
    }

    var str = [
        '比我们这里的算命先生厉害，算得准，也有很好的开运建议。',
        '还不错，婚姻方面算的很好，推荐的择偶标准也是我想要的。',
        '事业方面实在是分析得太好了，悬着适合自己的工作很重要。',
        '婚姻方面真的准！提供很好的相处建议，对未来的婚姻有信心！',
        '感情内容非常准，希望17年能像大师所说的那样组建幸福家庭！',
        '超赞！分析得很好，大师真的超级厉害！',
        '说我的财运好，我在这一方面确实一直有好运！',
        ' 事业分析的很准，一直在纠结要不要自己创业，还是听大师的！',
        '大师分析的好准，非常感谢老师的建议指导。',
        '分析得好准，希望17年真如分析所说那样能当上主管。',
        '本来准备下半年结婚的，大师算我下半年结婚的，准！',
        '分析得很详细，比本地的算命先生还要准。',
        '婚姻和事业建议有帮助，值得一看！',
        '算我事业不太好，最近确实亏了不少钱，希望能转运！',
        '结果内容很好，也有很多建议，相信17年一定会更顺利！',
        '事业和财运算得好准，跳槽发展果然是适合我的好选择！',
        '分析还是很准的，对感情有帮助，明年应该就如大师说的结婚！',
        '感谢老师提供的事业建议，明年努力就能升职了！',
        '一生的情况分析的好准，算我17年就能找到女朋友。开心！',
        '分析得好准，非常感谢老师的建议指导！',
    ];
    var strname = [
        '黄先生 佛山 ',
        '王女士 宁波 ',
        '吴先生 南京 ',
        '郭先生 成都 ',
        '汤女士 沈阳 ',
        '汪女士 台湾 ',
        '黄先生 澳门 ',
        '苏女士 新加坡',
        '李先生 香港 ',
        '吴先生 广州 ',
        '李先生 湛江 ',
        '黄先生 广西 ',
        '胡先生 上海 ',
        '李先生 北京 ',
        '余先生 苏州 ',
        '刘女士 天津 ',
        '郭女士 重庆 ',
        '孟先生 杭州 ',
        '王先生 无锡 ',
        '亓女士 青岛 ',
    ];
    str = shuffle(str);
    strname = shuffle(strname);
    var td = (new Date()).Format("yyyy-MM-dd");
    var date = Math.round((+new Date(td)) / 1000);
    var str2 = [];
    for (var i = 0; i < str.length; i++) {
        date = date + getRandomInt(1000, 3000);
        str2.push('<li>' + " " + strname[i] + " " + str[i] + '</li>');
    }
    if (document.getElementById('coll')) {
        document.getElementById('coll').innerHTML = str2.join('');
    }
    if (document.getElementById('pinglun')) {
        str = shuffle(str);
        strname = shuffle(strname);
        var str3 = [];
        for (var i = 0; i < str.length; i++) {
            date = date + getRandomInt(1000, 3000);
            str3.push('<li class="swiper-slide"><h4>' + strname[i] + '：</h4><p>' + str[i] + '</p></li>');
        }
        document.getElementById('pinglun').innerHTML = str3.join('');
    }
}
