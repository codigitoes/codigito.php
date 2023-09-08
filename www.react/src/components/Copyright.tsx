import { Typography } from "@mui/material";
import { Link } from "react-router-dom";

const Copyright: React.FC = () => {
    return (
        <Typography variant="body2" color="text.secondary" align="center" sx={{ pt: 4 }}>
            {'Copyright © '}
            <Link color="inherit" to="/">
                Your Website
            </Link>
            {new Date().getFullYear()}
        </Typography>
    );
}

export default Copyright;