// 包装函数
module.exports = function(grunt) {

    // 任务配置
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),     //读取写好的package.json配置文件

        //配置任务transport 管理文件依赖
        transport: {
            demo2: {
                files: {
                    //将这4个模块文件变成互相依赖的4个文件 放入当前目录的.bulid文件夹下
                    '.bulid' : ['main.js', 'drag.js', 'scale.js', 'range.js']
                }
            }
        },

        //配置任务concat 合并文件
        concat: {
            demo2: {
                files: {
                    //将上面已形成依赖的4个文件 合并放入当前目录的dist文件夹下 形成合并文件main.jss
                    'dist/main.js' : ['.bulid/main.js', '.bulid/drag.js', '.bulid/scale.js', '.bulid/range.js']
                }
            }
        },

        //配置任务uglify 压缩文件
        uglify: {
            demo2: {
                files: {
                    //将上面形成的合并文件main.js压缩成main.min.js
                    'dist/main.min.js' : ['dist/main.js']
                }
            }
        }

    });

    // 任务加载
    //加载文件依赖管理任务
    grunt.loadNpmTasks('grunt-cmd-transport');
    //加载合并文件任务
    grunt.loadNpmTasks('grunt-cmd-concat');
    //加载压缩任务
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // 任务启动 启动transport concat uglify三个任务 default的意思就是命令行grunt运行 不需要grunt-后缀
    // grunt.registerTask('default', ['transport']);
    grunt.registerTask('default', ['transport', 'concat', 'uglify']);

};