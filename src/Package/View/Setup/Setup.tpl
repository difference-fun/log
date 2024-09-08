{{R3M}}
{{$register = Package.Difference.Fun.Log:Init:register()}}
{{if(!is.empty($register))}}
{{Package.Difference.Fun.Log:Import:role.system()}}
{{Package.Difference.Fun.Log:Import:log.handler()}}
{{Package.Difference.Fun.Log:Import:log.processor()}}
{{Package.Difference.Fun.Log:Import:log()}}
{{/if}}