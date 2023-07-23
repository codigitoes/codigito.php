import { Box, Divider, Grid } from "@mui/material";

type HomeHeaderProps = {
    title:string;
    description:string;
    element?:React.ReactNode|undefined;
};

const HomeHeader:React.FC<HomeHeaderProps> = ({title,description,element}) => {
    return (
        <div>
            <Box sx={{
                width: '100%',
                height: '350px'
            }}>
                <Grid 
                    container 
                    direction='row' 
                    justifyContent='center' 
                    alignItems='center'
                    sx={{ height: '100%' }}>

                    <Grid item xs={5}>
                        <Grid 
                        container 
                        direction='column' 
                        justifyContent='center' 
                        alignItems='center'
                        sx={{ height: '100%' }}>

                            <Grid item>{title}</Grid>
                            <Grid item>{description}</Grid>
                            {element !== undefined && <Grid item sx={{mt:4, width:'100%'}}>{element}</Grid>}

                        </Grid>
                    </Grid>
                </Grid>
            </Box>
            <Divider/>
        </div>
    );
};

export default HomeHeader;