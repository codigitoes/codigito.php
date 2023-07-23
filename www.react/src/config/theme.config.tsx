import { CssBaseline, ThemeProvider, createTheme } from "@mui/material";
import React from "react";

type ThemeProp = {
    children: JSX.Element
}

const themePalette  = {
    BG :'#12181b',
    LIME :'#C8FA5F',
    FONT_GLOBAL: 'JetBrains Mono'
}

const theme = createTheme({
    palette: {
        mode: 'dark',
        background: {
            default: themePalette.BG
        },
        primary: {
            main: themePalette.LIME 
        }
    },
    typography: {
        fontFamily: themePalette.FONT_GLOBAL
    }
});

const ThemeConfig: React.FC<ThemeProp> = ({children}) => {
    return (
    <ThemeProvider theme={theme}>
        <CssBaseline/>
        {children}
    </ThemeProvider>)
}

export default ThemeConfig;