<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

	// BEGIN CSS ---------------------------------------------------------------
	protected function cssFileCollection($subdir = NULL) {
		$www = $this->context->params['wwwDir'] . '/css' . ($subdir ? '/' . $subdir : '');
		$collection = new \WebLoader\FileCollection($www, [ 'css', 'less' ]);

		// Názov presenteru
		$file = strtolower(substr($this->getName(), strrpos(':' . $this->getName(), ':')));
		// Názov presenteru aj s modulmi oddelenými bodkami
		$moduleDotFile = str_replace(':', '.', strtolower($this->getName()));
		$collection->addFile('per-page/' . $file, FALSE);
		$collection->addFile('per-page/' . $moduleDotFile, FALSE);

		// Názov akcie
		$file = $file . '.' . strtolower($this->getView());
		// Názov akcie aj s modulmi
		$moduleDotFile = $moduleDotFile . '.' . strtolower($this->getView());
		$collection->addFile('per-page/' . $file, FALSE);
		$collection->addFile('per-page/' . $moduleDotFile, FALSE);

		return $collection;
	}

	protected function createComponentCss($name) {
		$compiler = \WebLoader\Compiler::createCssCompiler($this->cssFileCollection(), $this->context->params['wwwDir'] . '/webtemp');
		$compiler->setJoinFiles($this->context->params['productionMode']);
		$compiler->addFileFilter(new \WebLoader\Filter\LessFilter());

		return new \WebLoader\Nette\CssLoader($compiler, $this->template->basePath . '/webtemp');
	}
	// END CSS -----------------------------------------------------------------

	// BEGIN JS ----------------------------------------------------------------
	protected function jsFileCollection($subdir = NULL) {
		$www = $this->context->params['wwwDir'] . '/js' . ($subdir ? '/' . $subdir : '');
		$collection = new \WebLoader\FileCollection($www, [ 'js', 'coffee' ]);

		// Názov presenteru
		$file = strtolower(substr($this->getName(), strrpos(':' . $this->getName(), ':')));
		// Názov presenteru aj s modulmi oddelenými bodkami
		$moduleDotFile = str_replace(':', '.', strtolower($this->getName()));
		$collection->addFile('per-page/' . $file, FALSE);
		$collection->addFile('per-page/' . $moduleDotFile, FALSE);

		// Názov akcie
		$file = $file . '.' . strtolower($this->getView());
		// Názov akcie aj s modulmi
		$moduleDotFile = $moduleDotFile . '.' . strtolower($this->getView());
		$collection->addFile('per-page/' . $file, FALSE);
		$collection->addFile('per-page/' . $moduleDotFile, FALSE);

		return $collection;
	}

	protected function createComponentJs($name) {
		$compiler = \WebLoader\Compiler::createJsCompiler($this->jsFileCollection(), $this->context->params['wwwDir'] . '/webtemp');
		$compiler->setJoinFiles($this->context->params['productionMode']);
		$compiler->addFileFilter(new \WebLoader\Filter\CoffeeFilter);

		return new \WebLoader\Nette\JavaScriptLoader($compiler, $this->template->basePath . '/webtemp');
	}
	// END JS ------------------------------------------------------------------
}
