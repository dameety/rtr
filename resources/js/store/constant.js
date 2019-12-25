const path = window.location.origin;


// auth
export const LOGIN_API = path + "/api/v1/auth/login";

export const MEAL_API = path + "/api/v1/meals";

export const DRIVER_API = path + "/api/v1/drivers";

export const CHECKOUT_API = path + "/api/v1/orders";

export const ORDER_API = path + "/api/v1/orders";

export const REGISTER_API = path + "/api/v1/auth/register";


// auth store
export const AUTH_REQUEST = "auth/login";
export const REGISTER_REQUEST = "auth/register";
export const LOGIN_REQUEST = "auth/login";
export const AUTH_SUCCESS = "auth/auth_success";
export const USER_DETAILS = "auth/user_details";
export const AUTH_LOGOUT = "auth/auth_logout";

