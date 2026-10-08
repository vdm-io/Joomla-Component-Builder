<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\View;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\View\DocumentMetadataInterface;


/**
 * View Document Metadata Class.
 * 
 * Builds the statements a view runs to set the document metadata: the
 * description, the keywords, the robots, the author, and whatever the item
 * itself carries.
 * 
 * A view that reads one item takes its metadata from that item and falls back
 * on the menu parameters; a view that reads a list has only the parameters. A
 * view whose own custom get method carries the name of the view is read as the
 * first kind, since that method is where the item then comes from.
 * 
 * How the document is reached is what the compile target decides, and it is the
 * two extension points below.
 * 
 * @since  6.1.7
 */
class DocumentMetadata implements DocumentMetadataInterface
{
	/**
	 * Build the statements that set the document metadata of a view.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string  The statements, or nothing when the view wants no metadata.
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string
	{
		if ($view['settings']->main_get->gettype == 1
			&& isset($view['metadata'])
			&& $view['metadata'] == 1)
		{
			return $this->itemMetadata();
		}
		elseif (isset($view['metadata']) && $view['metadata'] == 1)
		{
			// lets check if we have a custom get method that has the same name as the view
			// if we do then it posibly can be that the metadata is loaded via that method
			// and we can load the full metadata structure with its vars
			if (isset($view['settings']->custom_get)
				&& ArrayHelper::check(
					$view['settings']->custom_get
				))
			{
				$found     = false;
				$searchFor = 'get' . $view['settings']->Code;
				foreach ($view['settings']->custom_get as $custom_get)
				{
					if ($searchFor == $custom_get->getcustom)
					{
						$found = true;
						break;
					}
				}
				// now lets see
				if ($found)
				{
					return $this->itemMetadata($view['settings']->code);
				}
				else
				{
					return $this->listMetadata();
				}
			}
			else
			{
				return $this->listMetadata();
			}
		}

		return '';
	}

	/**
	 * Build the metadata of a view that reads one item.
	 *
	 * @param   string  $item  The property the item is read from.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	protected function itemMetadata(string $item = 'item'): string
	{
		$meta   = [];
		$meta[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the meta description";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metadesc) && \$this->" . $item . "->metadesc)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->itemDescription(
			"\$this->" . $item . "->metadesc"
		);
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2)
			. "elseif (\$this->params->get('menu-meta_description'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->itemDescription(
			"\$this->params->get('menu-meta_description')"
		);
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the key words if set";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metakey) && \$this->" . $item . "->metakey)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->document()
			. "->setMetadata('keywords', \$this->" . $item
			. "->metakey);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2)
			. "elseif (\$this->params->get('menu-meta_keywords'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->document()
			. "->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check the robot params";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->robots) && \$this->" . $item . "->robots)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->document()
			. "->setMetadata('robots', \$this->" . $item
			. "->robots);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "elseif (\$this->params->get('robots'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->document()
			. "->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if autor is to be set";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->created_by) && \$this->params->get('MetaAuthor') == '1')";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->document()
			. "->setMetaData('author', \$this->" . $item
			. "->created_by);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if metadata is available";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metadata) && \$this->" . $item . "->metadata)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . "\$mdata = json_decode(\$this->" . $item
			. "->metadata,true);";
		$meta[] = Indent::_(3) . "foreach (\$mdata as \$k => \$v)";
		$meta[] = Indent::_(3) . "{";
		$meta[] = Indent::_(4) . "if (\$v)";
		$meta[] = Indent::_(4) . "{";
		$meta[] = Indent::_(5) . $this->document() . "->setMetadata(\$k, \$v);";
		$meta[] = Indent::_(4) . "}";
		$meta[] = Indent::_(3) . "}";
		$meta[] = Indent::_(2) . "}";

		return implode(PHP_EOL, $meta);
	}

	/**
	 * Build the metadata of a view that reads a list.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	protected function listMetadata(): string
	{
		$meta   = [];
		$meta[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the meta description";
		$meta[] = Indent::_(2)
			. "if (\$this->params->get('menu-meta_description'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->document()
			. "->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the key words if set";
		$meta[] = Indent::_(2)
			. "if (\$this->params->get('menu-meta_keywords'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->document()
			. "->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check the robot params";
		$meta[] = Indent::_(2) . "if (\$this->params->get('robots'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . $this->document()
			. "->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = Indent::_(2) . "}";

		return implode(PHP_EOL, $meta);
	}

	/**
	 * How the generated view reaches its document.
	 *
	 * @return  string  The expression the metadata statements are called on.
	 *
	 * @since   6.1.7
	 */
	protected function document(): string
	{
		return "\$this->getDocument()";
	}

	/**
	 * Build the statement that sets the description of a view reading one item.
	 *
	 * Joomla 4 and later hand it to setDocumentTitle(), which is what the
	 * legacy compiler wrote, and it is left as it was.
	 *
	 * @param   string  $value  The expression the description is read from.
	 *
	 * @return  string  The statement.
	 *
	 * @since   6.1.7
	 */
	protected function itemDescription(string $value): string
	{
		return "\$this->setDocumentTitle(" . $value . ");";
	}
}

