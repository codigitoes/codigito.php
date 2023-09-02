import { Typography } from "@mui/material";
import React from "react";

type BlogpostCardProps = {
    title:string;
};

const BlogpostCard:React.FC<BlogpostCardProps> = ({title}) => {
    return (
        <>
        <Typography variant="h4">{title}</Typography>
        </>
    );
};

export default BlogpostCard;