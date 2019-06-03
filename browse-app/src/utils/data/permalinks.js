
import { CONFIG } from '../../globals/config';

export const isPlainPermalinkStructure = () => {
	return CONFIG.permalink_structure === '';
};
