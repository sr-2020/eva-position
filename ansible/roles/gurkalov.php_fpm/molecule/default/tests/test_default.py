import os

import testinfra.utils.ansible_runner

testinfra_hosts = testinfra.utils.ansible_runner.AnsibleRunner(
    os.environ['MOLECULE_INVENTORY_FILE']).get_hosts('all')


def test_authorized_keys_file(host):
    f = host.file('/var/run/php')

    assert f.exists
    assert f.user == 'www-data'
    assert f.group == 'www-data'
