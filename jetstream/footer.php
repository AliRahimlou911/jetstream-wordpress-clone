	</main>
	<footer class="bg-ink text-sky">
		<div class="mx-auto grid max-w-7xl gap-12 px-5 py-16 sm:px-8 md:grid-cols-[1.4fr_1fr_1fr]">
			<div class="max-w-sm">
				<?php jet_logo( true ); ?>
				<p class="mt-5 leading-relaxed text-sky/90"><?php echo esc_html( jet_opt( 'footer_about' ) ); ?></p>
			</div>
			<div>
				<h2 class="text-xs font-semibold uppercase tracking-[0.25em] text-sun">Explore</h2>
				<ul class="mt-5 space-y-3">
					<?php foreach ( jet_menu( 'footer' ) as $item ) : ?>
						<li><a href="<?php echo esc_url( $item[0] ); ?>" class="text-white transition hover:text-sun"><?php echo esc_html( $item[1] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div>
				<h2 class="text-xs font-semibold uppercase tracking-[0.25em] text-sun">Reach us</h2>
				<ul class="mt-5 space-y-3 text-white">
					<li class="flex items-center gap-3"><?php echo jet_icon( 'phone', 'h-4 w-4 text-sky' ); ?><?php echo esc_html( jet_opt( 'phone' ) ); ?></li>
					<li class="flex items-center gap-3"><?php echo jet_icon( 'mail', 'h-4 w-4 text-sky' ); ?><?php echo esc_html( jet_opt( 'email' ) ); ?></li>
					<li class="flex items-start gap-3"><?php echo jet_icon( 'map-pin', 'mt-1 h-4 w-4 text-sky' ); ?><?php echo esc_html( jet_opt( 'address' ) ); ?></li>
				</ul>
			</div>
		</div>
		<div class="border-t border-white/10 py-6 text-center text-sm text-sky/80">© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
