<footer class="footer">
	<div class="container">
		<div class="row align-items-center flex-row-reverse">
			<div class="col-auto ml-lg-auto">
				<div class="row align-items-center">
					<div class="col-auto">
						<ul class="list-inline list-inline-dots mb-0">
							<li class="list-inline-item"><a
								href="https://beian.miit.gov.cn"
								target="_blank">{{settings('system.icp_record')}}</a></li>
							<li class="list-inline-item"><a
								href="https://www.beian.gov.cn/"
								target="_blank">{{settings('system.police_record')}}</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
				Copyright © {{ gmdate('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name', 'Laravel') }}</a>.
				All rights reserved.
			</div>
		</div>
	</div>
</footer>