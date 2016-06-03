g = module.parent.exports

g.task "fonts", ->
  g.src ["fonts/**/*.{#{g.types.fonts}}", "web/vendor/**/fonts/*.{#{g.types.fonts}}"]
    .pipe g.p.flatten()
    .pipe g.dest "web/fonts"
    .pipe g.sync.reload stream: true

g.task "scripts", ->
  g.src "scripts/new/**/*.coffee"
    .pipe g.p.coffee()
    .on 'error', g.p.util.log
    .pipe g.js()
    .pipe g.p.concat "main.js"
    .pipe g.dest "web/js"
    .pipe g.sync.reload stream: true
