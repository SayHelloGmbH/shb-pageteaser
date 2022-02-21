import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";

import Edit from "./edit";

registerBlockType("shb/pageteaser", {
    edit: Edit,
});
