import React from "react";
import AppRouterProvider from "./RouterProvider";
import UserProvider from "./UserProvider";


export const App: React.FC<{}> = ({ }) => {
    return (<UserProvider><AppRouterProvider /></UserProvider>);
};
