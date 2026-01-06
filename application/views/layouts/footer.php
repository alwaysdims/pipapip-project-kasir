</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://datatables.net/legacy/v1/media/js/jquery.dataTables.js"></script>

<script>
	$('#example').DataTable();

</script>
<!-- BEGIN: JS Assets-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=[" your-google-map-api"]&libraries=places"></script>
<script src="<?= base_url('assets/enigma/Compiled/') ?>dist/js/app.js"></script>
<!-- END: JS Assets-->
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date()
							.valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	} else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->session->flashdata('success')): ?>
<script>
	Swal.fire({
		icon: 'success',
		title: 'Berhasil',
		text: '<?= $this->session->flashdata('success'); ?>',
		timer: 2000,
		showConfirmButton: false
	});

</script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<script>
	Swal.fire({
		icon: 'error',
		title: 'Gagal',
		text: '<?= $this->session->flashdata('error'); ?>',
		timer: 2500,
		showConfirmButton: false
	});

</script>
<?php endif; ?>

</body>

</html>
