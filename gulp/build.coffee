g = module.parent.exports

g.task "build", ["clean"], -> g.start "images", "scripts", "styles", "vendor"
