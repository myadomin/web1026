//主模块1 包含drag及scale子模块
define("main", [ "./drag", "./range", "./scale" ], function(require, exports, module) {
    exports.name = "主模块1";
    var oInpnut = document.getElementById("input1");
    var oDiv1 = document.getElementById("div1");
    var oDiv2 = document.getElementById("div2");
    var oDiv3 = document.getElementById("div3");
    // 引入drag模块 调用drag方法
    // 调用require方法时 无论drag.js相对当前这个main.js文件是怎样的相对路径 都统一用./drag.js调用
    require("./drag").drag(oDiv3);
    oInpnut.onclick = function() {
        oDiv1.style.display = "block";
        // 引入scale模块 调用scale方法 统一./scale.js调用
        require("./scale").scale(oDiv1, oDiv2);
    };
});

//拖拽模块drag
define("drag", [ "./range" ], function(require, exports, module) {
    // exports drag方法 供外部调用
    exports.drag = function(obj) {
        obj.onmousedown = function(ev) {
            var oEvent = ev || window.event;
            var disX = ev.clientX - obj.offsetLeft;
            var disY = ev.clientY - obj.offsetTop;
            document.onmousemove = function(ev) {
                var oEvent = ev || window.event;
                var maxLeft = document.documentElement.clientWidth - obj.offsetWidth;
                var maxTop = document.documentElement.clientHeight - obj.offsetHeight;
                var l = ev.clientX - disX;
                var t = ev.clientY - disY;
                //引入range模块 调用range方法 限制拖拽范围
                l = require("./range").range(l, maxLeft, 0);
                t = require("./range").range(t, maxTop, 0);
                obj.style.left = l + "px";
                obj.style.top = t + "px";
            };
            document.onmouseup = function() {
                document.onmousemove = null;
                document.onmouseup = null;
            };
            return false;
        };
    };
    // 查看当前模块对象 
    // console.log(module);
});

//拖动放大模块scale
define("scale", [ "./range" ], function(require, exports, module) {
    // exports scale方法 供外部调用
    exports.scale = function(obj1, obj2) {
        obj2.onmousedown = function(ev) {
            var oEvent = ev || window.event;
            var downX = ev.clientX;
            var downY = ev.clientY;
            var downWidth = obj1.offsetWidth;
            var downHeight = obj1.offsetHeight;
            document.onmousemove = function(ev) {
                var oEvent = ev || window.event;
                var w = ev.clientX - downX + downWidth;
                var h = ev.clientY - downY + downHeight;
                //引入range模块 调用range方法 限制拖动放大范围
                w = require("./range").range(w, 400, 100);
                h = require("./range").range(h, 400, 100);
                obj1.style.width = w + "px";
                obj1.style.height = h + "px";
            };
            document.onmouseup = function() {
                document.onmousemove = null;
                document.onmouseup = null;
            };
        };
    };
});

//范围限制取值模块range
define("range", [], function(require, exports, module) {
    // exports range方法 供外部调用
    exports.range = function(value, max, min) {
        if (value > max) {
            return max;
        } else if (value < min) {
            return min;
        } else {
            return value;
        }
    };
});
