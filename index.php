
<html ng-app="app">
<body>
  <form ng-controller="uploader">
	  <input type="file" onchange="angular.element(this).scope().filesChanged(this)" multiple file-input="files" />
	  <button ng-click="upload()">Upload</button>
	  <li ng-repeat="file in files">{{file.name}}</li>
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
  <script>
	angular.module('app',[]).
	directive('fileInput',['$parse',function($parse){
		return {
			restrict : 'A',
			link : function(scope,elm,attrs){
				elm.bind('change',function(){
					$parse(attrs.fileInput)
					.assign(scope,elm[0].files)
					scope.$apply()
				})
			}
		}
	}]).		
	controller('uploader',['$scope','$http',
		function($scope,$http){
			$scope.filesChanged =function(elm){
				$scope.files=elm.files
				$scope.$apply();
			}
			$scope.upload=function(){
				var fd=new FormData();
				angular.forEach($scope.files,function(file){
					fd.append('file',file)
				})
				$http.post('upload.php',fd,{
					transformRequest : angular.identity,
					headers:{'Content-Type' :undefined}
				})
				.success(function(d){
					console.log(d)
				});
			}
		}
	])
  </script>
</body>
</html>
