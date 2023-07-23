import { AppBar, Box, Button, Container, Grid, Stack, Toolbar, Typography } from "@mui/material";
import NavBar from "./NavBar";
import { Outlet } from "react-router-dom";

const RouterLayout:React.FC<unknown> = () => {
    return (
        <>
        <NavBar/>
        <Outlet/>
        </>
    );
}

export default RouterLayout;