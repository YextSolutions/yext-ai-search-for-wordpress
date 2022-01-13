export interface YextWizard extends HTMLElement {
	state: {
		step: number;
		payload: {
			settings: {
				plugin?: Object;
				search_bar?: Object;
				search_results?: Object;
				wizard?: {
					current_step: number;
					live: boolean;
					active: boolean;
				};
			};
		};
	};
}
