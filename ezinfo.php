<?php
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: SimpleLessCSS
// SOFTWARE RELEASE: 0.1
// COPYRIGHT NOTICE: Copyright (C) 1999-2011 Yannick Komotir
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

class simplelesscssInfo
{
    static function info()
    {
        $copyrightString = 'Copyright (C) 2011, Yannick Komotir';

        return array( 'Name'      => '<a href="http://projects.ez.no/ezjscore">Simple LESS CSS</a> extension',
                      'Version'   => '0.1',
                      'Copyright' =>  $copyrightString,
                      'License'   => 'MIT LICENSE and GPL VERSION 3',
                      'Includes the following third-party software' => array( 'Name' => 'lessphp',
                                                                              'Version' => "0.2.0",
                                                                              'Copyright' => 'http://leafo.net/',
                                                                              'License' => 'MIT LICENSE and GPL VERSION 3' )
                    );
    }
}

?>
