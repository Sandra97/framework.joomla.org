<?php
/**
 * Joomla! Framework Website
 *
 * @copyright  Copyright (C) 2014 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace Joomla\FrameworkWebsite\Controller\Api;

use Joomla\Application\AbstractApplication;
use Joomla\Controller\AbstractController;
use Joomla\FrameworkWebsite\View\Package\PackageJsonView;
use Joomla\Input\Input;
use TheIconic\Tracking\GoogleAnalytics\Analytics;

/**
 * API Controller handling a package's status data listing
 *
 * @method         \Joomla\FrameworkWebsite\WebApplication  getApplication()  Get the application object.
 * @property-read  \Joomla\FrameworkWebsite\WebApplication  $app              Application object
 *
 * @since          1.0
 */
class PackageControllerGet extends AbstractController
{
	use AnalyticsController;

	/**
	 * The view object.
	 *
	 * @var    PackageJsonView
	 * @since  1.0
	 */
	private $view;

	/**
	 * Constructor.
	 *
	 * @param   Analytics            $analytics  Analytics object.
	 * @param   PackageJsonView      $view       The view object.
	 * @param   Input                $input      The input object.
	 * @param   AbstractApplication  $app        The application object.
	 *
	 * @since   1.0
	 */
	public function __construct(Analytics $analytics, PackageJsonView $view, Input $input = null, AbstractApplication $app = null)
	{
		parent::__construct($input, $app);

		$this->analytics = $analytics;
		$this->view      = $view;
	}

	/**
	 * Execute the controller.
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function execute() : bool
	{
		$this->sendAnalytics();

		// Disable browser caching
		$this->getApplication()->allowCache(false);

		// This is a JSON response
		$this->getApplication()->mimeType = 'application/json';

		$this->view->setPackage($this->getInput()->getString('package'));

		$this->getApplication()->setBody($this->view->render());

		return true;
	}
}
