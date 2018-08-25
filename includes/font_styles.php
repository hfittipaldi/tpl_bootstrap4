<?php
/**
 * Method to generate a list of styles for the given font
 *
 * @param   string  $place Page section (body or titles)
 *
 * @return  string  Return all the font weights and their italic styles
 */
function fontStyles($place)
{
    $styles = '';
    if ($place === 'body')
    {
        $styles = ':400,400i,700,700i';
    }

    $fontStyles = JFactory::getApplication()->getTemplate(true)->params->get($place . 'FontStyles');
    if (!empty($fontStyles))
    {
        $styles .= ',';
        if ($place === 'titles')
        {
            $styles = ':';
        }

        foreach ($fontStyles as $style)
        {
            $styles .= $style;
            if ($place === 'body')
            {
                $styles .= ',' . $style . 'i';
            }
            if (next($fontStyles))
            {
                $styles .= ',';
            }
        }
    }

    return $styles;
}
