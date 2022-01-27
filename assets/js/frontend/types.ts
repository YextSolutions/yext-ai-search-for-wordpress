export interface YextSearchBarConfig {
	labelText?: string;
	submitText?: string;
	submitIcon?: string;
	placeholderText?: string;
	promptHeader?: string;
	redirectUrl?: string;
	cssClass?: string;
}

export interface SearchBarOptions extends YextSearchBarConfig {
	name?: string;
	container?: string;
}

export interface YextComponents {
	searchBar?: {
		props: YextSearchBarConfig;
	};
}

export interface YextPluginConfig {
	apiKey: string;
	experienceKey: string;
	locale?: string;
	businessId?: string;
	answersIframeUrl?: string;
	experienceVersion?: string;
}

export interface AnswersUIOptions extends YextPluginConfig {
	templateBundle?: Object;
	onReady?: Function;
}
