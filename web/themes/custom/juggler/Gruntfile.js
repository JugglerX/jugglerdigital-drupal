module.exports = function (grunt) {
  require('load-grunt-tasks')(grunt);
  require('time-grunt')(grunt);

  var jsLibs = [
    "js/scripts.js"
  ];

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        sourceComments: false,
        sourceMap: true,
        outputStyle: 'expanded'
      },
      style: {
        files: {
          'css/style.css': 'scss/style.scss'
        }
      }
    },

    jshint: {
      all: [
        'Gruntfile.js',
        jsLibs
      ]
    },

    uglify: {
      dist: {
        options: {
          sourceMap: true,
          preserveComments: 'none'
        },
        files: {'js/scripts.min.js': [jsLibs]}
      }
    },

    watch: {
      js: {
        files: [
          jsLibs,
          'Gruntfile.js'
        ],
        tasks: ['uglify']
      },
      scss: {
        files: 'scss/**/*.scss',
        tasks: ['sass:style']
      }
    },

    autoprefixer: {
      options: {
        browsers: ['Last 2 versions', 'IE 10', 'IE 11'],
        cascade: false,
        remove: false,
        map: false
      },
      css: {
        src: 'css/autodesk.css'
      }
    },

    bless: {
      css: {
        options: {},
        files: {
          'blessed/autodesk.css': 'css/autodesk.css'
        }
      }
    },

    cssmetrics: {
      dev: {
        src: [
          'css/autodesk.css'
        ]
      }
    },

    removescsscomments: {
      your_target: {
        options: {
          singleline: true,
          multiline: true
        },
        src: ['scss/**/*.scss']
      }
    },

    browserSync: {
      dev: {
        bsFiles: {
          src : 'css/style.css'
        },
        options: {
          watchTask: true,
          proxy: "service-market.autodesk.com",
          injectChanges: false
        }
      }
    }





  });

  grunt.registerTask('build', ['sass', 'autoprefixer', 'jshint', 'uglify']);
  grunt.registerTask('default', ['build']);
  grunt.registerTask('sync', ['browserSync','watch']);
  // grunt.loadNpmTasks('grunt-browser-sync');
};
