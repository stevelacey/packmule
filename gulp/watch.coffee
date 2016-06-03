g = module.parent.exports

g.task "watch", ->
  g.sync
    proxy: "packmule"
    open: false
    notify: false
    reloadOnRestart: true

  g.watch "images/**/*", ["images"]
  g.watch "scripts/**/*.coffee", ["scripts"]
  g.watch "styles/**/*.scss", ["styles"]
