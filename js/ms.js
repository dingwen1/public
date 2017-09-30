 /*
  *  全局js
  */
 function loginout() {
     if (Number(localStorage.logincode)) {
         $.get("data/l&r&o/loginout.php");
     }
 };

 /* 传入时间戳得到距离现在多久 */
 function linow(a) {
     var n = new Date().getTime() - Number(a);
     return parseInt(n / (1000 * 60 * 60 * 24));
 }

 /* 这个函数控制评论栏的提交等事件 */
 function commsub() {

 }

/* 写一个函数加载页面avatorinfo的数据 */
function avatorinfoDataLoad() {
    $.post("data/avatorinfo/datarequest.php", {
        uid:location.search.slice(5)
    }, data => { 
        console.log(data);
        /* 开始处理数据 */
        var user = data.usermsg[0];
        var html = `<p><img src="${user.avatar}"></p>
                    <p class="name">${user.user_name}</p>
                    <p class="p3">${user.addr}</p>
                    <p class="p3">作品数：<span class="redfont">${data.promsg.length}</span></p>
                    <p class="p3">简介：<span>${user.userIntro}</span></p>`;
        $("#avatormessage").append(html);
        var html = "";
        for (var p of data.promsg){
            html += `<div class="col-md-4 col-xs-4">
                        <div class="ori-up">
                            <a href="proinfo.html?pid=${p.pid}"><img src="${p.pic}"></a>
                        </div>
                        <div class="ori-down">
                            <p class="title"><a href="proinfo.html?pid=${p.pid}">${p.pname}</a></p>
                            <p class="pro_fam">——${p.fname}——</p>
                            <p class="pro_time">${linow(p.issueTime)}天前上传</p>
                            <p class="pro_messa">
                                <span class="parig">${p.popNum}</span>人气/
                                <span class="pcomm">${p.commNum}</span>评论/
                                <span class="preco">${p.likeNum}</span>推荐
                            </p>
                            <p class="pavator">
                                ${p.user_name}
                                <img src="${p.avatar}" >
                            </p>
                        </div>
                    </div>`;
        }
         $("#userpro").append(html);
    });
}

 /* 写一个index页面数据请求以及处理函数 */
 function indexDataLoad() {
     $.get("data/index/datarequest.php", data => {
         console.log(data);
         /* 处理newmsg */
         var newmsg = data.newmsg[0];
         $("#newmsg").append(`<a href="avatorinfo.html?uid=${newmsg.uid}">${newmsg.user_name}</a>
                            在${new Date(Number(newmsg.commTime)).toLocaleString()}对作品《
                            <a href="proinfo.html?pid=${newmsg.pid}">${newmsg.pname} </a>》发表了评论`)
         /* 处理pro */
         var html = "";
         for (var p of data.pro) {
             html += `<div class="col-md-3 col-xs-3">
                        <div class="ori-up">
                            <a href="proinfo.html?pid=${p.pid}"><img src="${p.pic}"></a>
                        </div>
                        <div class="ori-down">
                            <p class="title"><a href="proinfo.html?pid=${p.pid}">${p.pname}</a></p>
                            <p class="pro_fam">——${p.fname}——</p>
                            <p class="pro_time">${linow(p.issueTime)}天前上传</p>
                            <p class="pro_messa">
                                <span class="parig">${p.popNum}</span>人气/
                                <span class="pcomm">${p.commNum}</span>评论/
                                <span class="preco">${p.likeNum}</span>推荐
                            </p>
                            <p class="pavator">
                                ${p.user_name}
                                <img src="${p.avatar}">
                            </p>
                        </div>
                    </div>`;
         }
         $("#origina").append(html);
         /* 处理ao数据 */
         var html = "";
         for (var a of data.ao) {
             html += `<div class="col-md-4 col-xs-4">
                        <span><a href="avatorinfo.html?uid=${a.uid}"><img src="${a.avatar}"></a></span>
                        <span>
                            <p><a href="avatorinfo.html?uid=${a.uid}">${a.user_name}</a></p>
                            <p>${a.addr}</p>
                            <p>作品：${a.proNum}</p>
                        </span>
                    </div>`;
         }
         $("#autor_show").html(html);
         /* 需要处理沙龙  sl 数据了 */
         var html = "";
         for (var s of data.sl) {
             html += `<p>
                        <a href="proinfo.html?pid=${s.pid}">${s.pname}</a>
                        <span>${new Date(Number(s.issueTime)).toLocaleDateString()}</span>
                      </p>`;
         }
         $("#salon_show").html(html);
     })
 }

 /* 写一个函数处理avator页面的数据请求及处理 */
 function avatorDataLoad(page) {
     $.post("data/avator/datarequest.php", {
         akw: decodeURIComponent(location.search.slice(5)),
         page: page
     }, data => {
         /* 处理页面数据 */
         var html = "";
         for (var a of data.data) {
             html += `<div class="col-md-2 col-xs-2 avator_show">
                        <div class="tou_img">
                            <a href="avatorinfo.html?uid=${a.uid}"><img src="${a.avatar}"></a>
                        </div>
                        <div>
                            <p><a href="avatorinfo.html?uid=${a.uid}">${a.user_name}</a></p>
                            <p>${a.addr}</p>
                            <p>作品数：<span>${a.proNum}</span></p>
                        </div>
                    </div>`;
         }
         $("#origina").html(html);
         /* 生成分页组件 */
         var html = `<span>
                共<span class="datanum">${data.dataNum}</span>条记录，当前第<span class="pagecurrent">${data.currentPage}</span>/<span class="pagecount">${data.totalPage}</span>页，每页
                <span class="pagesize">${data.pageSize}</span>条记录
                        </span>
                    <span id="pagegrup">
                        `;
         for (var i = 1; i <= data.totalPage; i++) {
             if (i == data.currentPage) {
                 html += `<a href="#" class="btn_slect">${i}</a>`;
             } else {
                 html += `<a href="#">${i}</a>`
             }
         }
         html += `<a href="#">下一页</a>
                        <a href="#">尾页</a>
                </span>`;
         $("#page_msg").html(html);
         $("#page_msg").off("click", "a")
         $("#page_msg").on("click", "a", e => {
             e.preventDefault();
             var page = $(e.target).html();
             if (page == "下一页") {
                 var nextPage = Number(data.currentPage) + 1;
                 if (nextPage > data.totalPage) nextPage--;
                 avatorDataLoad(nextPage);
             } else if (page == "尾页") {
                 console.log(data.totalPage)
                 avatorDataLoad(data.totalPage);
             } else {
                avatorDataLoad(page);
             }
             $("html,body").animate({
                 "scrollTop": "190"
             }, "slow");
         })

     });
 }
 /* 写一个proinfo页面的数据加载函数 */
 function proinfoLoad() {
     $.get("data/proload/proload.php" + location.search, data => {
         console.log(data);
         var pro = data.pro[0];
         console.log(pro);
         /* 处理pro详细数据 */
         var html = `<div class="col-md-9 col-xs-9">
                            <p><i class="glyphicon glyphicon-text-size"></i> ${pro.pname}</p>
                            <p>分类：<span>${pro.fname}</span></p>
                            <p>人气：<span>${pro.popNum}</span> 评论：<span>${pro.commNum}</span> 推荐：<span>${pro.likeNum}</span></p>
                        </div>
                        <div class="col-md-3 col-xs-3">
                            <a href="avatorinfo.html?uid=${pro.uid}"><img src="${pro.avatar}"></a>
                            <div>
                                <a href="avatorinfo.html?uid=${pro.uid}">${pro.user_name}</a><br>
                                <span>${linow(pro.issueTime)}天前发布</span>
                            </div>
                        </div>`;
         $("#textHead").html(html);
         $("#textBody").html(pro.info);
         /* 处理评论加载 */
         var comm = data.comm;
         if (comm.length == 0) {
             $("#yourcomms").append(`<p>暂无评论数据</p>`);
         } else {
             var html = "";
             for (var c of comm) {
                 html += `<div class="yourcomm">
                            <a href="avatorinfo.html?uid=${c.uid}"><img src="${c.avatar}"></a>
                          <div>
                            <p><a href="avatorinfo.html?uid=${c.uid}">${c.user_name}</a> <span>${new Date(Number(c.commTime)).toLocaleString()}</span></p>
                            <p>
                              ${c.comment}
                            </p>
                          </div>
                            <p class="clearfix"></p>
                          </div>`;
             }
             $("#yourcomms").append(html);
         }

         /* 处理点赞按钮的选择点击 */
         if (localStorage.logincode == 1 && data.islike) {
             $("#like-btn").removeClass("a");
         } else {
             $("#like-btn").one("click", e => {
                 console.log(e.target)
                 if (localStorage.logincode == 1) {
                     //发送ajax请求添加表like'
                     $.get("data/proload/updatelike.php" + location.search, e => {
                         if (e) {
                             $("#like-btn").removeClass("a");
                             console.log("喜欢成功")
                         }
                     });
                 } else {
                     setTimeout(() => {
                         location = "login.html"
                     }, 2000);
                     alert("需要登陆，跳转中... ...");
                 }
             })
         }

     });

 }

 /* 写一个usermessage.html页面的数据加载函数 */
 function userMessageLoad() {
     if (localStorage.logincode == 1) {
         $.get("data/userupdate/request.php", data => {
             console.log(data);
             var usermsg = data.usermsg[0];
             var promsg = data.promsg;
             console.log(usermsg, promsg);
             var html = `<p>
                <img src=${usermsg.avatar}> ${usermsg.uname} (普通会员) <br>
            </p>
            <p>用户资料</p>
            <p>用户姓名：<span>${usermsg.user_name}</span></p>
            <p>Email邮箱：<span>${usermsg.email}</span></p>
            <p>省市：<span>${usermsg.addr}</span></p>
            <p>注册时间：<span>${new Date(Number(usermsg.registerTime)).toLocaleString()}</span></p>
            <p>联系电话：<span>${usermsg.phone}</span></p>
            <p>联系QQ：<span>${usermsg.qq}</span></p>
            <p>简介：<span>${usermsg.userIntro}</span></p>`;
             $("#usermessage").html(html);
             $("#njsform-username").val(usermsg.user_name);
             $("#njsform-email").val(usermsg.email);
             $("#njsform-phone").val(usermsg.phone);
             $("#njsform-qq").val(usermsg.qq);
             $("#njsform-message").val(usermsg.userIntro);

             /* 加载我的作品数据 */
             var html = '';
             for (var v of promsg) {
                 html += `<div class="col-md-4 col-xs-4" data-pid="${v.pid}">
                            <div class="ori-up">
                                <a href="proinfo.html?pid=${v.pid}"><img src=${v.pic}></a>
                            </div>
                            <div class="ori-down">
                                <p class="title"><a href="production.html?pid=${v.pid}">${v.pname}</a></p>
                                <p class="pro_fam">——${v.fname}——</p>
                                <p class="pro_time">${linow(v.issueTime)}天前上传</p>
                                <p class="pro_messa">
                                    <span class="parig">${v.popNum}</span>人气/
                                    <span class="pcomm">${v.commNum}</span>评论/
                                    <span class="preco">${v.likeNum}</span>推荐
                                </p>
                                <p class="pavator">
                                    ${v.user_name}
                                    <img src="${v.avatar}" alt="">
                                </p>
                            </div>
                        </div>`;
             }
             $("#mypro").html(html);


         }).then(() => {
             /* 配置点击头像事件  以及头像的上传*/
             $("#usermessage img").click(() => {
                 $(".pic-tailor").toggleClass("picshow");
             });
             $image = $('.img-container > img');
             $image.cropper("reset");
             $image.cropper("setAspectRatio", 120 / 120);
             $("#imgok").click(() => {
                 var avatar = $image.cropper("getCroppedCanvas", {
                     "width": 120,
                     "height": 120
                 }).toDataURL();
                 $(".pic-tailor").removeClass("picshow");
                 $.post("data/userupdate/avatar.php", {
                     avatar: avatar
                 }, data => {
                     if (data) {
                         $("#usermessage img").attr("src", avatar);
                     } else {
                         alert("您还没有登陆");
                     }
                 });
             });
         });

     }
 }


 (() => {


     /* 引入头部HTML */
     $.get("nave.html").then(html => {
         $("#nave").html(html);
     }).then(() => {
         /* 给页面导航A绑定点击事件,上传所选的fam值 */
         $("div.familygroup ul").on("click", "a[href='production.html']", e => {
             localStorage.proFam = $(e.target).html();
         });
     }).then(() => {
         /* 给搜索按钮绑定事件 */
         $("button.input-btn").click(() => {
             location = "production.html?kw=" +
                 $("input[name='keyword']").val();
         });
     }).then(() => {
         $.get("data/l&r&o/hello.php")
     });

     /* 引入页脚HTML并绑定backtop事件 */
     $.get("footer.html").then(htm => {
         $("#footer").html(htm);
     }).then(() => {
         $("#backtop").click(function () {
             $("html,body").animate({
                 "scrollTop": "0"
             }, "slow");
         })
     });
     /* 页面滚动控制backtop状态 */
     $(document).ready(function () {
         $(window).scroll(function () {
             if ($(window).scrollTop() > 500) {
                 $("#backtop").fadeIn(500);
             } else {
                 $("#backtop").fadeOut(500);
             }
         })
     });

     /* 上传作品按钮的选择跳转 */
     $("a.upload").click(e => {
         e.preventDefault();
         if (Number(localStorage.logincode)) {
             location = "proupload.html";
         } else {
             location = "login.html";
         }
     });




 })();

 (() => {
     /* 解决作品框的高度自动调整问题 */

     var $oris = $("div.origina>div");
     $oris.css("height", parseFloat($oris.css("width")) * 1.4);

     $(window).resize(() => {
         var $oris = $("div.origina>div");
         $oris.css("height", parseFloat($oris.css("width")) * 1.4);
     })
 })();