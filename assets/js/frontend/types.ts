export interface SearchBarOptions {
	name: string;
	container: string;
	labelText?: string;
	submitText?: string;
	placeholderText?: string;
	redirectUrl?: string;
}

export interface AnswersUIOptions {
	apiKey: string;
	experienceKey: string;
	experienceVersion?: string;
	locale?: string;
	businessId?: string;
	templateBundle?: Object;
	onReady: Function;
}
