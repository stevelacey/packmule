g = module.parent.exports

g.task "images", ->
  deferred = g.q.defer()

  g.src "images/**/*"
    .pipe g.p.imagemin().on 'end', -> deferred.resolve()
    .pipe g.dest "web/images"
    .pipe g.sync.reload stream: true

  symlinks =
    "web/images":          "web/uploads/thumbnails"
    "web/images/chosen":   "lib/vendor/chosen/chosen/*"
    "web/images/fancybox": "lib/vendor/fancybox/source/*"

  g.src(from).pipe g.p.symlink(to) for to, from of symlinks

  deferred.promise
