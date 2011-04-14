<?php
Apu::import("/action/BaseAction.php");
class BenchmarkCaseAction extends BaseAction {
	function doIndex() {
?>
<style>
body, table, tr, th, td {
	font-family: Lucida Console;
	font-size: 11px;
}
</style>
<?php
		$iteration = 10;
		$urls = array();
		$urls[] = 'http://codeigniter.dev.ku/benchmark/';
		$urls[] = 'http://todo.dev.ku/benchmark/';
		$urls[] = 'http://cakephp.dev.ku/benchmarks';
		$this->_benchmark($urls, $iteration);
		echo '<br/><br/>';
		$urls = array();
		$urls[] = 'http://codeigniter.dev.ku/benchmark/usedb/';
		$urls[] = 'http://todo.dev.ku/benchmark/usedb/';
		$urls[] = 'http://cakephp.dev.ku/benchmarks/usedb/';
		$this->_benchmark($urls, $iteration);
	}

	function _benchmark($urls, $iteration) {
		$result = array();
		echo "<table border=\"1\" width=\"100%\">\n<tr>\n<th>x</th>\n";
		reset($urls);
		foreach ($urls as $url) {
			echo "<th>$url</th>\n";
		}
		echo "</tr>\n";
		for($i=0;$i<$iteration;$i++) {
			echo "<tr>\n<td align=\"right\">$i</td>";
			reset($urls);
			foreach ($urls as $url) {
				$str = file_get_contents($url);
				$num = floatval(substr($str, strpos($str, "\n") + 1));
				echo "<td align=\"right\">".$num."</td>\n";
				$result[$url] = @$result[$url] + $num;
			}
			echo "</tr>\n";
		}
		echo "<tr>\n<td>Result</td>\n";
		reset($urls);
		foreach ($urls as $url) {
			echo "<td align=\"right\">".$result[$url] / $iteration."</td>\n";
		}
		echo "</tr>\n";
		echo "</table>\n";
	}
}
?>