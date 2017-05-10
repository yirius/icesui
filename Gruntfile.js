/**
 * Created by yangyuance1 on 17/5/9.
 */
module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> Author: Yirius <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: ['src/assets/js/util.js', 'src/assets/js/admin.js', 'src/assets/js/iceslist.js', 'src/assets/js/icesform.js', 'src/assets/js/zui.js'],
                dest: '../../../public/static/js/<%= pkg.name %>.min.js'
            }
            //admin: {
            //    src: 'src/assets/js/admin.js',
            //    dest: '../../../public/static/js/admin.min.js'
            //}
        },
        concat : {
            css : {
                src: ['src/assets/css/zui.css', 'src/assets/css/style.css'],
                dest:'src/dist/all.css'
            }
        },
        cssmin: {
            options: {
                banner: '/*! <%= pkg.name %> Author: Yirius <%= grunt.template.today("yyyy-mm-dd") %> */\n',
                ////美化代码
                //beautify: {
                //            //中文ascii化，非常有用！防止中文乱码的神配置
                //            ascii_only: true
                //        }
            },
            css: {
                src:'src/dist/all.css',
                dest:'../../../public/static/css/<%= pkg.name %>.min.css'
            }
        },
        copy: {
            fonts: {
                files: [
                    {
                        expand: true,
                        cwd: 'src/assets/fonts/',
                        src: '*',
                        dest: '../../../public/static/fonts/'
                    }
                ]
            },
            libs: {
                expand: true,
                cwd: 'src/assets/lib/',
                src: '**',
                dest: '../../../public/static/lib/'
            }
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-css');
    grunt.loadNpmTasks('grunt-contrib-copy');

    // Default task(s).
    grunt.registerTask('default', ['uglify', 'concat', 'cssmin', 'copy']);

};
