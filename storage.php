<?php
			$storage_path = ($cfg['storage_path']);
            $storage_name = ($cfg['storage_name']);
           
            /* get disk space free (in bytes) */
            $df = disk_free_space($storage_path);
            /* and get disk space total (in bytes)  */
            $dt = disk_total_space($storage_path);
            /* now we calculate the disk space used (in bytes) */
            $du = $dt - $df;
            /* percentage of disk used - this will be used to also set the width % of the progress bar */
            $dp = sprintf('%.2f',($du / $dt) * 100);
            /* and we format the size from bytes to MB, GB, etc. */
            $df = formatSize($df);
            $du = formatSize($du);
            $dt = formatSize($dt);
            function formatSize( $bytes )
			{
            $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
            for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
                   return( round( $bytes, 2 ) . " " . $types[$i] );
}
			?>
            
            <div class="storage">        
                        <i class="icon_drive"></i>
                        <?php echo "$storage_name:  $du Used - $df Free - $dt Total"; ?>
                        </a>
                </div>           
				
