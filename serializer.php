<?php
// PHP serializer
// Copyright (C) 2015 Bernhard Waldbrunner
/*
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP Serializer</title>
	<meta name="author" content="Bernhard Waldbrunner">
	<style>
		* {
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		}
		body {
			font-size: 10pt;
		}
		label {
			display: block;
			font-weight: bold;
		}
		pre, textarea {
			font-family: Monaco, "Courier New", monospace;
		}
		input[type=submit] {
			text-transform: uppercase;
		}
	</style>
</head>
<body>

<h1>Edit serialized PHP data structures</h1>
<?php $canManipulate = false; ?>
<form id="serializer" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<?php
	$d = unserialize($_POST['data']);
	if ($d !== false && @$_POST['code']) {
		$canManipulate = true;
		eval($_POST['code']);
	}
	?>
	<?php if (!@$_POST['serialize']): ?>
		<?php if (@$_POST['data']): ?>
			<input type="hidden" name="data" value="<?php echo htmlspecialchars($_POST['data']); ?>">
			<label for="f_code">Manipulation PHP statements (use $d to access the data)</label>
			<textarea cols="100" rows="10" name="code" id="f_code" required><?php echo htmlspecialchars($_POST['code']); ?></textarea>
			<label>Data structure</label>
			<pre><?php echo htmlspecialchars(print_r($d, true)); ?></pre>
		<?php else: ?>
			<label for="f_data">Serialized data string</label>
			<textarea cols="100" rows="10" name="data" id="f_data" required></textarea>
		<?php endif; ?>
		<div class="buttons">
			<input type="submit" id="b_submit" value="<?php echo @$_POST['data'] ? 'Manipulate' : 'Unserialize'; ?>">
			<?php if ($canManipulate): ?>
				<input type="submit" id="b_serialize" name="serialize" value="Serialize">
			<?php endif; ?>
			<input type="reset" id="b_reset" value="Clear">
		</div>
	<?php endif; ?>
	<?php if ($canManipulate and @$_POST['serialize']): ?>
		<label for="f_result">Manipulated serialized data string</label>
		<textarea id="f_result" cols="100" rows="10" readonly><?php echo htmlspecialchars(serialize($d)); ?></textarea>
	<?php endif; ?>
</form>

</body>
</html>
