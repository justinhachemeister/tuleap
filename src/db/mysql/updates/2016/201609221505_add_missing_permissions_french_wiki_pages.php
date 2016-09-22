<?php
/**
 * Copyright (c) Enalean, 2016. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

class b201609221505_add_missing_permissions_french_wiki_pages extends ForgeUpgrade_Bucket
{
    public function description()
    {
        return 'Add missing permissions on french wiki pages';
    }

    public function preUp()
    {
        $this->db = $this->getApi('ForgeUpgrade_Bucket_Db');
    }

    public function up()
    {
        $ugroup_project_admin = 4;
        $ugroup_wiki_admin    = 14;
        $sql = "INSERT INTO permissions
                SELECT 'WIKIPAGE_READ', id, $ugroup_project_admin
                FROM wiki_page
                LEFT JOIN permissions ON CAST(id AS CHAR) = object_id AND permission_type = 'WIKIPAGE_READ'
                WHERE object_id IS NULL AND pagename LIKE 'AdministrationDePhpWiki%'
                UNION
                SELECT 'WIKIPAGE_READ', id, $ugroup_wiki_admin
                FROM wiki_page
                LEFT JOIN permissions ON CAST(id AS CHAR) = object_id AND permission_type = 'WIKIPAGE_READ'
                WHERE object_id IS NULL AND pagename LIKE 'AdministrationDePhpWiki%'";

        $result = $this->db->dbh->exec($sql);

        if ($result === false) {
            throw new ForgeUpgrade_Bucket_Exception_UpgradeNotComplete('Missing permissions on french wiki pages have not been applied');
        }
    }
}
