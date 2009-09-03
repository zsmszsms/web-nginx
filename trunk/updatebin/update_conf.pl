#!/usr/bin/perl
$commit_log="commitlog.log";
$md5_file="md5_file.log";
$updatelog="/opt/soft/nginx/logs/nginx_update.log";
$updatetag="tag";
$nginx_to_new="mv -f *.vservice /opt/soft/nginx/conf/vservice/";
$localip="10.0.121.8";
$nginx_conf_restart="/sbin/service nginx restart";
$commit_server="lftpget http://feedback.hexun.com/yunwei_project/nginx_manager/commitlog/commitlog.log";
$getmd5_file="lftpget http://feedback.hexun.com/yunwei_project/nginx_manager/commitlog/md5_file.log";
$update_ok_sum=0;
$update_time=localtime;
system($getmd5_file);
open(LOG,">>".$updatelog);
if(-e $commit_log){
open(SMD5,$md5_file);
$smd5_code=<SMD5>;
close(SMD5);
open(UPTAG,$updatetag);
$up_conf_tag=<UPTAG>;
close(UPTAG);
@get_conf_array="";
$cmd5_code_res=`md5sum $commit_log`;
@cmd5_code=split(' ',$cmd5_code_res);
        if($smd5_code eq $cmd5_code[0]){
        print LOG $update_time." config not is modif , don't update!! \n";
        exit;
        }
        system($commit_server);
        open(FILE,$commit_log) or die "error";
                while($commit_log_res=<FILE>){
                ($committime,$serverip,$getconfpath)=split(',',$commit_log_res);
                        if($localip eq $serverip){
                                if($committime > $up_conf_tag){
                                        if(!grep(/$getconfpath/,@get_conf_array)){
                                        $get_conf_file = "lftpget http://feedback.hexun.com/yunwei_project/nginx_manager/".$getconfpath;
                                        system($get_conf_file);
                                        print LOG $update_time." download ".$getconfpath." is ok! \n";
                                        push(@get_conf_array,$getconfpath);
                                        $update_ok_sum ++;
                                        }
                                }
                        }
                $next_up_conf_tag=$committime;
                }
        open(UPTAG,">".$updatetag);
        print UPTAG $next_up_conf_tag;
        close(UPTAG);
}
else{
    system($commit_server);
        open(FILE,$commit_log) or die "error";
                while($commit_log_res=<FILE>){
                ($committime,$serverip,$getconfpath)=split(',',$commit_log_res);
                        if($localip eq $serverip){
                                if($committime > $up_conf_tag){
                                        if(!grep(/$getconfpath/,@get_conf_array)){
                                        $get_conf_file = "lftpget http://feedback.hexun.com/yunwei_project/nginx_manager/".$getconfpath;
                                        system($get_conf_file);
                                        print LOG $update_time." download ".$getconfpath." is ok! \n";
                                        push(@get_conf_array,$getconfpath);
                                        $update_ok_sum ++;
                                        }
                                }
                        }
                $next_up_conf_tag=$committime;
                }
        open(UPTAG,">".$updatetag);
        print UPTAG $next_up_conf_tag;
        close(UPTAG);
}
if($update_ok_sum == 0){
print LOG $update_time." config not is modif , don't update!! \n";
exit;
}
system($nginx_to_new);
system('/opt/soft/nginx/sbin/nginx -t 2>nginx.status');
open(NXSTAT,"nginx.status");
        while(<NXSTAT>){
        $nginx_status .= $_;
        }
close(NXSTAT);
if($nginx_status =~ /syntax is ok/ and $nginx_status =~ /tested successfully/){
system($nginx_conf_restart);
system("curl http://nginxmg.idc.hexun.com/client_status.php -d status=1");
print LOG $update_time."update nginx config ok!! \n";
}else{
system("curl http://nginxmg.idc.hexun.com/client_status.php -d status=0 -d error='$nginx_status'");
print LOG $update_time."update nginx config error!! \n";
}
close(FILE);
close(LOG);

