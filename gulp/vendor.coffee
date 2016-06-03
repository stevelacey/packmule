g = module.parent.exports

g.task "vendor", ->
  g.src [
    "web/vendor/jquery/dist/jquery.min.js",
    "web/vendor/bootstrap/dist/js/bootstrap.min.js",
  ]
    .pipe g.js()
    .pipe g.p.concat "vendor.js"
    .pipe g.dest "web/js"
    .pipe g.sync.reload stream: true
