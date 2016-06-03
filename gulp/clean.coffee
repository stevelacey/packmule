g = module.parent.exports
del = require("del")

g.task "clean", (cb) ->
  del ["web/{admin/js,css,fonts,images,js}"], cb
