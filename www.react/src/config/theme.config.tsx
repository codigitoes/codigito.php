import { ThemeProvider, createTheme } from "@mui/material";
import React from "react";

type ThemeProp = {
    children: JSX.Element
}

const theme = createTheme({
    palette: {
        mode: 'dark',
        background: {
            default: 'pink'
        }
    }
});

export const ThemeConfig: React.FC<ThemeProp> = ({children}) => {
    return <ThemeProvider theme={theme}>{children}</ThemeProvider>
}