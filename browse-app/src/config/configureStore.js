import { createStore, applyMiddleware, compose } from 'redux';
import thunkMiddleware from 'redux-thunk';
import { createLogger } from 'redux-logger';
import rootReducer from '../reducers';

const loggerMiddleware = createLogger();
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

export default function configureStore(preloadedState) {
	let middlewares;
	if (process.env.NODE_ENV=='production') {
		middlewares = applyMiddleware(
			thunkMiddleware,
		);
	} else {
		middlewares = applyMiddleware(
			thunkMiddleware,
			loggerMiddleware
		);
	}

	return createStore(
		rootReducer,
		preloadedState,
		composeEnhancers(middlewares)
	);
}
