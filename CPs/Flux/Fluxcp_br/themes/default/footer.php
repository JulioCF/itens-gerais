<?php if (!defined('FLUX_ROOT')) exit; ?>
							</td>
							<td bgcolor="#f5f5f5"></td>
						</tr>

						<tr>
							<td><img src="<?php echo $this->themePath('img/content_bl.gif') ?>" style="display: block" /></td>
							<td bgcolor="#f5f5f5"></td>
							<td><img src="<?php echo $this->themePath('img/content_br.gif') ?>" style="display: block" /></td>
						</tr>
					</table>
				</td>
				<!-- Spacing between content and horizontal end-of-page -->
				<td style="padding: 10px"></td>
			</tr>
			<?php if (Flux::config('ShowCopyright')): ?>
			<tr>
				<td colspan="3"></td>
				<td id="copyright">
					<p>
						<strong>Powered by Flux Painel de Controle (<?php echo htmlspecialchars(Flux::VERSION) ?><?php echo Flux::REPOSVERSION ? '.'.Flux::REPOSVERSION : '' ?>)</strong>
						&mdash; Copyright &copy; 2008-2012, Matthew Harris, Nikunj Mehta, Xantara, Megasantos and JulioCF.
					</p>
				</td>
				<td></td>
			</tr>
			<?php endif ?>
			<?php if (Flux::config('ShowRenderDetails')): ?>
			<tr>
				<td colspan="3"></td>
				<td id="info">
					<p>
						Página gerada em <strong><?php echo round(microtime(true) - __START__, 5) ?></strong> segundo(s).
						Quantidade de queries executadas: <strong><?php echo (int)Flux::$numberOfQueries ?></strong>.
						<?php if (Flux::config('GzipCompressOutput')): ?>Compressão Gzip: <strong>Habilitada</strong>.<?php endif ?>
					</p>
				</td>
				<td></td>
			</tr>
			<?php endif ?>
		</table>
	</body>
</html>