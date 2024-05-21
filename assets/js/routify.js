var Routify = (function(win) {

	return {
		go: function(hash) {
			if (!hash) {
				return;
			}

			if (win.history.pushState) {
				win.history.pushState(null, null, hash);
			} else {
				win.location.hash = hash;
			}
		}
	};
})(window);